<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2011 Ladislav Marek <ladislav@marek.su>
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Wkhtmltopdf;

/**
 * @author Ladislav Marek <ladislav@marek.su>
 */
class PageMeta implements IDocumentPart
{

	/** @var string */
	private $type;

	/** @var string */
	public $left;

	/** @var string */
	public $center;

	/** @var string */
	public $right;

	/** @var string */
	public $file;

	/** @var string */
	public $html;

	/** @var bool */
	public $line = FALSE;

	/** @var string */
	public $fontName;

	/** @var string */
	public $fontSize;

	/** @var int */
	public $spacing = 0;


	/**
	 * @param string
	 */
	public function __construct($type)
	{
		$this->type = $type;
	}


	/**
	 * @param  Document
	 * @return string
	 */
	public function buildShellArgs(Document $document)
	{
		$file = $this->file;
		if ($file === NULL && $this->html !== NULL) {
			$file = $document->saveTempFile((string) $this->html);
		}

		if ($file !== NULL) {
			$cmd = "--$this->type-html " . escapeshellarg($file);
		} else {
			$cmd = "--$this->type-left " . escapeshellarg($this->left)
				. " --$this->type-center " . escapeshellarg($this->center)
				. " --$this->type-right " . escapeshellarg($this->right);
		}
		$cmd .= ' --' . ($this->line ? '' : 'no-') . "$this->type-line";
		if ($this->fontName !== NULL) {
			$cmd .= " --$this->type-font-name " . escapeshellarg($this->fontName);
		}
		if ($this->fontSize !== NULL) {
			$cmd .= " --$this->type-font-size " . escapeshellarg($this->fontSize);
		}
		return $cmd;
	}

}
