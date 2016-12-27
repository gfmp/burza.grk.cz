<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Forms;

use App\Model\ORM\Helpers;
use App\Model\ORM\Repository\CategoriesRepository;
use Nette\Application\UI\Form;

final class BookForm extends Form
{

	/**
	 * @param CategoriesRepository $categoriesRepository
	 */
	public function __construct(CategoriesRepository $categoriesRepository)
	{
		//        $this->addCheckbox('active', 'Je knížka k prodeji?');

		$this->addText('name', 'Název')
			->setRequired('Název knihy je povinný.');

		$this->addText('price', 'Cena')
			->addRule(self::INTEGER, 'Cena musí být celočíselná.')
			->setRequired('Cena knihy je povinná.');

		$this->addSelect('category', 'Kategorie')
			->setPrompt('--- Kategorie ---')
			->setItems($categoriesRepository
				->findAll()
				->orderBy('name', 'ASC')
				->fetchPairs('id', 'name'))
			->setRequired('Kategorie knihy je povinná.');

		$this->addTextArea('description', 'Popisek')
			->setRequired('Popisek knihy je povinný.');

		$this->addRadioList('wear', 'Opotřebení')
			->setItems(Helpers::getWears())
			->setRequired('Opotřebení knihy je povinné.');

		$this->addText('author', 'Autor');

		$this->addText('publisher', 'Nakladatelství');

		$this->addText('year', 'Rok vydání')
			->addCondition(self::FILLED)
			->addRule(self::INTEGER, 'Rok vydání musí být celočíselný.')
			->addRule(self::PATTERN, 'Zadejte rok jako RRRR.', '[0-9]{4}');

		$this->addHidden('id');

		$this->addSubmit('send', 'Uložit');
	}

}
