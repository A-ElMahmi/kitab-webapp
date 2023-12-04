<?php
namespace Framework;

use IvoPetkov\HTML5DOMDocument;
use IvoPetkov\HTML5DOMElement;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Session\Session;


class Form {
    private $dom;
    private $inputs;
    private $formValues;
    private $errors = [];
    private $userConstraints = [];
    
    /**
     * Create a new Form
     *
     * @param  string $formView Name of form blade file. Must be in app/views/forms/
     * @param  Session $session 
     * @param  array $bladeData Data to pass to form when rendering using blade
     */
    public function __construct(private string $formView, private Session $session, array $bladeData = []) {
        $bladeRendered = Blade::make("forms.$formView", $bladeData);
        
        $this->dom = new HTML5DOMDocument(encoding: "UTF-8");
        $this->dom->loadHTML($bladeRendered, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);

        $this->inputs = $this->dom->querySelectorAll("input[name]");

        if (($formData = $session->get("form-$formView")) !== null) {
            $this->formValues = $formData["formValues"];
            $this->errors = $formData["errors"];
        } else {
            $this->formValues = new InputBag();
        }
    }
        
    /**
     * Generates form - adds persistent input values, inserts errors, removes client-side validation
     *
     * @return string
     */
    public function render() : string {
        foreach ($this->inputs as $input) {
            $input->removeAttribute("required");
            $input->removeAttribute("minlength");
            $input->removeAttribute("maxlength");
            
            $inputName = $input->getAttribute("name");

            if ($input->getAttribute("type") !== "password") {
                $input->setAttribute("value", $this->formValues->get($inputName) ?? "");
            }

            $input->setAttribute("onfocus", "this.select()");

            $small = $this->dom->createElement("small", isset($this->errors[$inputName]) ? $this->errors[$inputName] : "");
            $small->classList->add("error");
            $input->parentNode->after($small); // Inserts it after parent node (Label)
        }
        
        return $this->dom->saveHTML();
    }
    
    /**
     * Validates form input
     *
     * @param  InputBag $formValues
     * @return bool true if form is ok, false if form fails 
     */
    public function validate(InputBag $formValues) : bool {
        $this->formValues = $formValues;
        $this->errors = [];
        
        $noError = true;
        $attributeConstraints = [
            "required" => [fn($value) => $value !== "", "This field is required"],
            "minlength" => [fn($value, $attr) => strlen($value) >= intval($attr), "Minimum length is %s"],
            "maxlength" => [fn($value, $attr) => strlen($value) <= intval($attr), "Maximum length is %s"],
        ];

        foreach ($this->inputs as $input) {
            $noError = $this->validateAttribute($input, "required", ...$attributeConstraints["required"]) && $noError;
        
            $inputName = $input->getAttribute("name");
            if ($this->formValues->get($inputName) === "") continue;
            
            $noError = $this->validateAttribute($input, "minlength", ...$attributeConstraints["minlength"]) && $noError;
            $noError = $this->validateAttribute($input, "maxlength", ...$attributeConstraints["maxlength"]) && $noError;

            $noError = $this->validateConstraints($inputName) && $noError;
        }
        
        $this->session->set("form-" . $this->formView, [
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
    
    /**
     * Add Validation check to form field
     *
     * @param  string $inputName Name attribute of Input field
     * @param  \Closure $condition Anonymous function with condition. 
     *                             Must take 1 parameter (value of input) and return bool (true if no error, false otherwise)
     * @param  string $errorMessage Error to be displayed if input fails validation
     * @return void
     */
    public function addConstraint(string $inputName, \Closure $condition, string $errorMessage) {
        $this->userConstraints[$inputName][] = ["condition" => $condition, "errorMessage" => $errorMessage];
    }
    
    /**
     * Add Validation check to form field from input attribute
     *
     * @param  string $inputName Name attribute of Input field
     * @param  \Closure $condition Anonymous function with condition. 
     *                             Must take 1 parameter (value of input) and return bool (true if no error, false otherwise)
     * @param  string $errorMessage Error to be displayed if input fails validation
     * @return void
     */
    private function validateAttribute(HTML5DOMElement $input, string $attribute, \Closure $condition, string $errorMessage) : bool {
        $inputName = $input->getAttribute("name");

        // If there's already an error, no need for validate
        if (isset($this->errors[$inputName]) === true) return false;
        
        $formValue = $this->formValues->get($inputName);
        $attributeValue = $input->getAttribute($attribute);
        
        if ($input->hasAttribute($attribute) && call_user_func($condition, $formValue, $attributeValue) === false) {
            $this->errors[$inputName] = sprintf($errorMessage, $attributeValue);
            return false;
        }
        
        return true;
    }
    
    private function validateConstraints(string $inputName) : bool {
        // If there's already an error, no need for validate
        if (isset($this->errors[$inputName]) === true) return false;

        // Don't change anything if no constraints defined
        if (isset($this->userConstraints[$inputName]) === false) return true;

        $formValue = $this->formValues->get($inputName);
            
        foreach ($this->userConstraints[$inputName] as $constraint) {
            if (call_user_func($constraint["condition"], $formValue) === false) {
                $this->errors[$inputName] = $constraint["errorMessage"];
                return false;
            }
        }

        return true;
    }
}