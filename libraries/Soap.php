
<?php

class Soap_server extends CI_controller {

    function __construct() {
        parent::__construct();

        $this->load->library("Nusoap_lib");

        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("Bills_WSDL", "urn:Soap_server");

        $this->nusoap_server->register("hello", // method name
        array("name" => "xsd:string"), // input parameters
        array("return" => "xsd:string"), // output parameters
        "urn:Soap_server", // namespace
        "urn:Soap_server#hello", // soapaction
        "rpc", // style
        "encoded", // use
        "Says hello to the caller" // documentation
        );
    }

    function index() {

        if ($this->uri->rsegment(3) == "wsdl") {
            $_SERVER['QUERY_STRING'] = "wsdl";
        } else {
            $_SERVER['QUERY_STRING'] = "";
        }

        function hello($name) {
            return "Hello, " . $name;
        }

        $this->nusoap_server->service(file_get_contents("php://input"));
    }

}