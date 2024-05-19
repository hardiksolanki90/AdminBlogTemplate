import "./bootstrap";
import "flowbite";
import "flowbite-datepicker";
import "flowbite/dist/datepicker.turbo.js";
import $ from "jquery"; // Added import statement for jQuery
import "summernote/dist/summernote-lite.js";


$("#summernote").summernote({
    height: 200,
    placeholder: 'Type here...',
});