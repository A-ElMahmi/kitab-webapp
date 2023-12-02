<?php
namespace Framework;

use IvoPetkov\HTML5DOMDocument;
use IvoPetkov\HTML5DOMElement;
use Symfony\Component\HttpFoundation\InputBag;
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
    
    public function render() : string {
        $inputs = $this->dom->querySelectorAll("input");
        
        foreach ($inputs as $input) {
            $input->removeAttribute("required");
            $input->removeAttribute("minlength");
            $input->removeAttribute("maxlength");
            
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

    public function validate(InputBag $formValues) : bool {
        $this->formValues = $formValues;
        $this->errors = [];
        
        $noError = true;
        $constraints = [
            "required" => [fn($value, $_) => $value === "", "This field is required"],
            "minlength" => [fn($value, $attr) => strlen($value) < intval($attr), "Minimum length is %s"],
            "maxlength" => [fn($value, $attr) => strlen($value) > intval($attr), "Maximum length is %s"],
        ];

        $inputs = $this->dom->querySelectorAll("input");
        
        foreach ($inputs as $input) {
            $noError = $this->validateField($input, "required", ...$constraints["required"]) && $noError;
        
            $inputName = $input->getAttribute("name");
            if ($this->formValues->get($inputName) === "") continue;
            
            $noError = $this->validateField($input, "minlength", ...$constraints["minlength"]) && $noError;
            $noError = $this->validateField($input, "maxlength", ...$constraints["maxlength"]) && $noError;
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

    private function validateField(HTML5DOMElement $input, string $attribute, \Closure $condition, string $errorMessage) : bool {
        $inputName = $input->getAttribute("name");
        $formValue = $this->formValues->get($inputName);
        $attributeValue = $input->getAttribute($attribute);

        if ($input->hasAttribute($attribute) && $condition($formValue, $attributeValue) === true) {
            if (!isset($this->errors[$inputName])) {
                $this->errors[$inputName] = sprintf($errorMessage, $attributeValue);
            }
            return false;
        }
        
        return true;
    }
}