<?php namespace DBDiff;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;


class Templater {

    function __construct($params, $up, $down) {
        $this->params = $params;
        $this->up = $up;
        $this->down = $down;
    }
    
    public function output() {
        $content = $this->getComments();
        $content .= $this->getContent();
        $showtime = date("Ymdhis");
        if (is_null($this->params->output)) {
            Logger::info("Writing migration file to ".getcwd()."/migratesql/".$showtime.'_migration_default.migration.sql');
            file_put_contents(getcwd()."/migratesql/".$showtime.'_migration_default.migration', $content);
        } else {
            Logger::info("Writing migration file to ".$this->params->output);
            return file_put_contents($this->params->output, $content);
        }
    }

    private function getComments() {
        if (!$this->params->nocomments) {
            return "# Generated by DBDiff\n# On ".date('m/d/Y h:i:s a', time())."\n\n";
        }
        return "";
    }

    private function getContent() {
        $compiler = new BladeCompiler(new Filesystem, ".");
        $template = $this->getTemplate();
        $compiled = $compiler->compileString(' ?>'.$template);
        $up = trim($this->up, "\n");
        $down = trim($this->down, "\n");
        ob_start();
        eval($compiled);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    private function getTemplate() {
        if (file_exists($this->params->template))
            return file_get_contents($this->params->template);
        return "#---------- UP ----------\n{{\$up}}\n#---------- DOWN ----------\n{{\$down}}";
    }
}
