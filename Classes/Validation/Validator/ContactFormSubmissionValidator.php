<?php

namespace DPN\Simplecf\Validation\Validator;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Björn Fromme <fromme@dreipunktnull.com>, dreipunktnull
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DPN\Simplecf\Domain\Model\ContactFormSubmission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Validation\Validator\GenericObjectValidator;

/**
 * Class ContactFormSubmissionValidator
 * @package DPN\Simplecf
 * @subpackage Validation\Validator
 */
class ContactFormSubmissionValidator extends GenericObjectValidator
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager
     */
    public function injectObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \DPN\Simplecf\Domain\Model\ContactFormSubmission $value
     * @return \TYPO3\CMS\Extbase\Error\Result
     */
    public function validate($value)
    {
        $fullSettings = GeneralUtility::removeDotsFromTS($this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT));
        $settings = $fullSettings['plugin']['tx_simplecf']['settings'];
        $mandatoryFields = GeneralUtility::trimExplode(',', $settings['mandatoryFields']);

        $contactBy = $value->getContactBy();
        array_push($mandatoryFields, $contactBy);

        foreach ($mandatoryFields as $field) {
            /** @var \TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator $notEmptyValidator */
            $notEmptyValidator = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Validation\\Validator\\NotEmptyValidator');
            $this->addPropertyValidator($field, $notEmptyValidator);
        }

        return parent::validate($value);
    }

    /**
     * @param object $object
     * @return boolean
     */
    public function canValidate($object)
    {
        return $object instanceof ContactFormSubmission;
    }

}
