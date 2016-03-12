<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DPN.' . $_EXTKEY,
    'Contactform',
    array(
        'ContactForm' => 'new,submit,confirm',
    ),
    array(
        'ContactForm' => 'new,submit',
    )
);
