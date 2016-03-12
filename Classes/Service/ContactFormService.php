<?php

namespace DPN\Simplecf\Service;

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

/**
 * Class ContactFormService
 * @package DPN\Simplecf
 * @subpackage Service
 */
class ContactFormService
{

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $manager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $manager)
    {
        $this->configurationManager = $manager;
    }

    /**
     * @param \DPN\Simplecf\Domain\Model\ContactFormSubmission $submission
     * @return boolean
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception
     */
    public function sendEmail(ContactFormSubmission $submission)
    {
        $settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

        $fromEmail = TRUE === (boolean)$settings['useUserMailAddress'] ? $submission->getEmail() : $settings['fromEmail'];
        $fromName = $settings['fromName'];
        $charset = $settings['charset'];
        $subject = $settings['subject'];
        $toEmail = $settings['toEmail'];
        $toName = $settings['toName'];

        $htmlView = $this->getView('ContactForm', 'html');
        $htmlView->assign('submission', $submission);
        $htmlView->assign('charset', $charset);
        $htmlView->assign('title', $subject);
        $htmlBody = $htmlView->render();

        $plainView = $this->getView('ContactForm', 'txt');
        $plainView->assign('submission', $submission);
        $plainView->assign('charset', $charset);
        $plainView->assign('title', $subject);
        $plainBody = $plainView->render();

        /** @var \TYPO3\CMS\Core\Mail\MailMessage $message */
        $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');

        $message->setTo(array($toEmail => $toName));
        $message->setFrom(array($fromEmail => $fromName));
        $message->setSubject($subject);
        $message->setCharset($charset);
        $message->setBody($htmlBody, 'text/html');
        $message->addPart($plainBody, 'text/plain');

        $message->send();

        return $message->isSent();
    }

    /**
     * @param string $templateName
     * @param string $format
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     */
    protected function getView($templateName, $format = 'html')
    {
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
        $view = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $view->setFormat($format);
        $view->getRequest()->setControllerExtensionName('simplecf');
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        $layoutRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']);
        $templatePathAndFilename = $templateRootPath . 'Email/' . $templateName . '.' . $format;
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        $view->setLayoutRootPaths(array($layoutRootPath));

        return $view;
    }

}
