<?php
/*
     Naronco Changelog Loader
 author: WebFreak001
website: www.naronco.com
version: 1.2

changelog:
v1.1.2:
 - Added ids
 - Added markcolor
v1.1:
 - Added comments
 - Added textformating
  -> Added colored text
  -> Added deleted text
  -> Added bold text
  -> Added italic text
  -> Added multiline
  -> Added underlined text
  -> Added marked text
v1.0:
 - Display text from logfiles
 - Added titles and entries
 - Added Copyrightbar
*/
class ChangelogLoader {
	private $src, $content;
	
	public function ChangelogLoader($src) {
		$this->src = $src;
		$this->reload();
	}

	public function reload() {
		$this->content = file($this->src);
	}
	
	private function render($string, $id) {
		$nstring = $string;
		$string = trim($string);
		if(strpos($string, "//") !== FALSE) $string = substr($string, 0, strpos($string, "//"));
		$string = str_replace("\\n", "<br/>", $string);
		if(strlen($string) > 0) {
			if($string[0] == "=") $string = "<h1>".trim(substr($string, 1))."</h1>";
			elseif($string[0] == "-") $string = "<h2>".trim(substr($string, 1))."</h2>";
			elseif($string[0] == "/") $string = "<del>".trim(substr($string, 1))."</del><br/>";
			elseif($string[0] == "\"") $string = "<b>".trim(substr($string, 1))."</b><br/>";
			elseif($string[0] == "!") $string = "<u>".trim(substr($string, 1))."</u><br/>";
			elseif($string[0] == "$") $string = "<i>".trim(substr($string, 1))."</i><br/>";
			elseif($string[0] == "&") $string = "<span style='background-color: #".substr($string, 1, 3)."'>".trim(substr($string, 4))."</span><br/>";
			elseif($string[0] == "#") $string = "<span style='color: ".substr($string, 0, 4)."'>".trim(substr($string, 4))."</span><br/>";
			else $string = "<span>$string</span><br/>";
			return "<span id='changelogitem$id'>".trim($string)."</span>";
		}
	}
	
	public function show($showtitle = FALSE) {
		if(is_array($this->content)) {
			if($showtitle) echo $this->src."<br/>";
			$i = 0;
			echo "<div id='changelog'>";
			foreach($this->content as $line) {
				echo $this->render($line, ++$i);
			}
			echo "</div>";
			echo "<center>Naronco ChangelogLoader v1.2 - OpenSource</center>";
		} else {
			echo "Failed to Render " + $this->src;
		}
	}
}
?>