<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Core\Latte;

use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

final class FormMacros extends MacroSet
{

	/**
	 * @param Compiler $compiler
	 *
	 * @return void
	 */
	public static function install(Compiler $compiler)
	{
		$me = new static($compiler);
		$me->addMacro('formErrors', [$me, 'macroFormErrors']);
	}

	/**
	 *  {formErrors}
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 *
	 * @return string
	 */
	public function macroFormErrors(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('echo App\Core\Latte\FormRuntime::renderFormErrors($_form)');
	}

}
