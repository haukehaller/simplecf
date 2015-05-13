<?php

namespace DPN\Simplecf\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Björn Fromme <fromme@dreipunktnull.com>, dreipunktnull
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

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/**
 * Class ContactFormSubmission
 * @package DPN\Simplecf
 * @subpackage Domain\Model
 */
class ContactFormSubmission extends AbstractValueObject {

	/**
	 * @var string
	 * @validate NotEmpty
	 * @validate SJBR\SrFreecap\Validation\Validator\CaptchaValidator
	 */
	protected $captcha;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $street;

	/**
	 * @var string
	 */
	protected $city;

	/**
	 * @var string
	 */
	protected $phone;

	/**
	 * @var string
	 * @validate EmailAddress
	 */
	protected $email;

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var string
	 */
	protected $contactBy = 'email';

	/**
	 * @return string
	 */
	public function getCaptcha() {
		return $this->captcha;
	}

	/**
	 * @param string $captcha
	 * @return ContactFormSubmission
	 */
	public function setCaptcha( $captcha ) {
		$this->captcha = $captcha;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return ContactFormSubmission
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * @param string $street
	 * @return ContactFormSubmission
	 */
	public function setStreet($street) {
		$this->street = $street;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @param string $city
	 * @return ContactFormSubmission
	 */
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param string $phone
	 * @return ContactFormSubmission
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return ContactFormSubmission
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param string $message
	 * @return ContactFormSubmission
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContactBy() {
		return $this->contactBy;
	}

	/**
	 * @param string $contactBy
	 * @return ContactFormSubmission
	 */
	public function setContactBy($contactBy) {
		$this->contactBy = $contactBy;
		return $this;
	}

}
