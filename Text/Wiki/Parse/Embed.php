<?php
// $Id$


/**
* 
* This class implements a Text_Wiki_Parse to embed the contents of a URL
* inside the page at render-time.  Typically used to get script output.
* This differs from the 'include' rule, which incorporates results at
* parse-time; 'embed' output does not get parsed by Text_Wiki, while
* 'include' ouput does.
*
* This rule is inherently not secure; it allows cross-site scripting to
* occur if the embedded output has <script> or other similar tags.  Be
* careful.
*
* @author Paul M. Jones <pmjones@ciaweb.net>
*
* @package Text_Wiki
*
*/

class Text_Wiki_Parse_Embed extends Text_Wiki_Parse {
	
	var $conf = array(
		'base' => '/path/to/scripts/'
	);
	
	/**
	* 
	* The regular expression used to find source text matching this
	* rule.
	* 
	* @access public
	* 
	* @var string
	* 
	*/
	
	var $regex = '/(\[\[embed )(.+?)(\]\])/i';
	
	
	/**
	* 
	* Generates a token entry for the matched text.  Token options are:
	* 
	* 'text' => The full matched text, not including the <code></code> tags.
	* 
	* @access public
	*
	* @param array &$matches The array of matches from parse().
	*
	* @return A delimited token number to be used as a placeholder in
	* the source text.
	*
	*/
	
	function process(&$matches)
	{	
    	$file = $this->getConf('base') . $matches[2];
    	ob_start();
    	include($file);
    	$options = array('text' => ob_get_contents());
    	ob_end_clean();
		return $this->wiki->addToken($this->rule, $options);
	}
}
?>