<?php
/**
 * MageINIC
 * Copyright (C) 2023 MageINIC <support@mageinic.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category MageINIC
 * @package MageINIC_SpeakSearch
 * @copyright Copyright (c) 2023 MageINIC (https://www.mageinic.com/)
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageINIC <support@mageinic.com>
 */

namespace MageINIC\SpeakSearch\ViewModel;

use MageINIC\SpeakSearch\Helper\Data as HeplerData;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Helper Data
 */
class Data implements ArgumentInterface
{
    /**
     * @var HeplerData
     */
    private HeplerData $datahelper;

    /**
     * @param Context $context
     * @param HeplerData $datahelper
     */
    public function __construct(
        Context    $context,
        HeplerData $datahelper
    ) {
        $this->datahelper = $datahelper;
    }

    /**
     * Get Enable
     *
     * @return mixed
     */
    public function getEnable(): mixed
    {
        return $this->datahelper->getEnable();
    }

    /**
     * Get Button Image
     *
     * @return mixed
     */
    public function getButtonImg(): mixed
    {
        return $this->datahelper->getButtonImg();
    }

    /**
     * Get Button Image Url
     *
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getButtonImgUrl(): ?string
    {
        return $this->datahelper->getButtonImgUrl();
    }

    /**
     * Get Image
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->datahelper->getImage();
    }
}
