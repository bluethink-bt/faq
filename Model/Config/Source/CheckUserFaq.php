<?php

namespace Bluethink\Faq\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class CheckUserFaq implements ArrayInterface
{
    /**
     * Set Array to Option
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'YES',
                'value' => '1'
            ],
            1 => [
                'label' => 'No',
                'value' => '0'
            ],
        ];

        return $options;
    }
}
