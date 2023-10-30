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

namespace MageINIC\SpeakSearch\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Helper Data
 */
class Data extends AbstractHelper
{
    /**
     * Voice Search Config path
     */
    public const SPEAKSEARCH_ENABLE = 'speaksearch/general/enable';
    public const VOICE_SEARCH_BUTTON_IMAGE = 'speaksearch/general/speaksearch_button_img';

    /**
     * Media path
     */
    public const MEDIA_FOLDER = 'mageINIC/speaksearch/';

    /**
     * @var StoreManagerInterface
     */
    public StoreManagerInterface $storeManager;

    /**
     * @var Repository
     */
    private Repository $assetRepo;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Repository $assetRepo
     */
    public function __construct(
        Context               $context,
        StoreManagerInterface $storeManager,
        Repository            $assetRepo
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
    }

    /**
     * Get Enable
     *
     * @return mixed
     */
    public function getEnable(): mixed
    {
        return $this->scopeConfig->getValue(
            self::SPEAKSEARCH_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Button Image
     *
     * @return mixed
     */
    public function getButtonImg(): mixed
    {
        return $this->scopeConfig->getValue(
            self::VOICE_SEARCH_BUTTON_IMAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Button Image Url
     *
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getButtonImgUrl(): ?string
    {
        $image = $this->getButtonImg();
        $buttonImg = null;
        if ($image) {
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            );
            $buttonImg = $mediaUrl . self::MEDIA_FOLDER . $image;
        }

        return $buttonImg;
    }

    /**
     * Get Image
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->assetRepo->getUrl("MageINIC_SpeakSearch::image/speaksearch.png");
    }
}
