<?php
namespace Wlinja\Classes;

class Markdown {
	private $string;
	
	public function __construct($markDown) {
		$this->string = $markDown;
	}
	
	public function toHtml() {
		//converto $this->string in HTML
		$text = htmlspecialchars($this->string, ENT_QUOTES, 'UTF-8');
		
		//strong(bold, grassetto)
		$text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
		$text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
		
		//emphasis (italic, corsivo)
		$text = preg_replace('/_([^_]+)_/', '<em>$1</em>', $text);
		$text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);
		
		//converto Windows(\r\n) in Unix (\n)
		$text = str_replace("\r\n", "\n", $text);
		//converto Macintosh(\r) in Unix (\n)
		$text = str_replace("\r", "\n", $text);
		
		//Paragrafi
		$text = '<p>' . str_replace("\n\n", '</p><p>', $text) . '</p>';
		//Fine riga
		$text = str_replace("\n", '<br>', $text);
		
		//[testo del link](URL del link)
		$text = preg_replace('/\[([^\]+])\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i', '<a href="$2">$1</a>', $text);
		
		return $text;
	}
}