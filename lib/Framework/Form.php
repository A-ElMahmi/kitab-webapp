<?php
namespace Framework;

use Symfony\Component\HttpFoundation\InputBag;
use IvoPetkov\HTML5DOMDocument;
use IvoPetkov\HTML5DOMElement;
use Symfony\Component\HttpFoundation\Session\Session;

class Form {
    private $dom;
    private $formValues;
    private $errors = [];

    public function __construct(private string $formView, private Session $session) {
        $this->dom = new HTML5DOMDocument(encoding: "UTF-8");
        $this->dom->loadHTMLFile(__DIR__."/../../app/views/forms/$formView.php", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        if (($formData = $session->get("form-$formView")) !== null) {
            $this->formValues = $formData["formValues"];
            $this->errors = $formData["errors"];
        } else {
            $this->formValues = new InputBag();
        }
    }
    
    public function make() : string {
        $form = $this->dom->querySelector("form");
        $form->setAttribute("novalidate", "");
        $this->dom->normalize();

        $inputs = $this->dom->querySelectorAll("input");
        
        foreach ($inputs as $input) {
            $inputName = $input->getAttribute("name");

            if (!in_array($input->getAttribute("type"), ["submit", "password"], strict: true)) {
                $input->setAttribute("value", $this->formValues->get($inputName) ?? "");
            }

            $input->setAttribute("onfocus", "this.select()");

            $small = $this->dom->createElement("small", isset($this->errors[$inputName]) ? $this->errors[$inputName] : "");
            $small->classList->add("error");
            $input->parentNode->after($small); // Inserts it after parent node (Label)
        }
        
        return $this->dom->saveHTML();
    }

    public function render() : string {
        return $this->make();
    }
    
    public function validate(InputBag $formValues) : bool {
        $noError = true;

        $this->formValues = $formValues;
        $this->errors = [];

        $inputs = $this->dom->querySelectorAll("input");
        
        foreach ($inputs as $input) {
            if ($input->getAttribute("type") === "submit") continue;

            $noError = $this->validateRequired($input) && $noError;
        }
        
        $this->session->set("form-test", [
            "formValues" => $this->formValues,
            "errors" => $this->errors,
        ]);

        return $noError;
    }

    public function clearSession() {
        $this->session->remove("form-" . $this->formView);

        $this->formValues = new InputBag();
        $this->errors = [];
    }
    
    private function validateRequired(HTML5DOMElement $input) : bool {
        $inputName = $input->getAttribute("name");

        if ($input->hasAttribute("required") && $this->formValues->get($inputName) === "") {
            $this->errors[$inputName] = "This field is required";
            return false;
        }
        
        return true;
    }
}