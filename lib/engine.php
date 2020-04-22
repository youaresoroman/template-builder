<?php
namespace MyTemplateEngine;
class constructor {
    // Tags array
    public $tags = [];

    // Template file
    private $template;

    // Messages
    public $messages;

    // Get the template file
    public function __construct( $project_name, $templateFile ) {
        $this->template = $this->getFile( $project_name, $templateFile );

        // If the template file is not accessible
        if ( !$this->template ) {
            $this->messages['errors'] = "Error! Can't load the template file '" . $_SERVER["DOCUMENT_ROOT"]."/$project_name/views/$templateFile" . "'";
            return false;
        }

    }

    public static function include( $project_name, $templateFile, ?array $tags = null )
    {
        $file = new constructor( $project_name, $templateFile);
        if (!is_null($tags)) {
            foreach ( $tags as $tag => $value) {
                $file->set($tag, $value);
            }
        }
        return $file->render();
    }

    public function getFile( $project_name, $file ) {
        if ( file_exists( $_SERVER["DOCUMENT_ROOT"]."/$project_name/views/$file" ) ) {

            $file = file_get_contents( $_SERVER["DOCUMENT_ROOT"]."/$project_name/views/$file" );
            return $file;
        } else {
            return false;
        }
    }

    // Set the '{tag}' with value
    public function set( string $tag, ?string $value ) {
        $this->tags[$tag] = $value;
    }

    public function setTags( array $tags ) 
    {
        foreach ($tags as $tag => $value) {
            $this->set($tag, $value);
        }
    }

    // Replaces all '{tags}' with corresponding values from $tags array
    private function replaceTags() {
        foreach ( $this->tags as $tag => $value ) {
            if ($this->template = str_replace( "{% ".$tag." %}", $value, $this->template )){
                $this->messages['tags'][$tag] = 'replaced';
            }
        }

        return true;
    }

    // Render the build template
    public function render() {
        $this->replaceTags();

        return $this->template;
    }
}
?>