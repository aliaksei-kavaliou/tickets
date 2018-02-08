<?php

namespace App\Model\Form;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * FilterType
 *
 * @author aliaksei
 */
class FilterType
{
    /**
     * @var \DateTime
     * @Assert\Date()
     */
    public $requiredDate;

    /**
     * Constructor
     * @param \DateTime $requiredDate
     */
    public function __construct(\DateTime $requiredDate)
    {
        $this->requiredDate = $requiredDate;
    }

}
