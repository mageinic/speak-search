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

namespace MageINIC\SpeakSearch\Model\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface;

/**
 * Block Image
 */
class Image extends \Magento\Config\Model\Config\Backend\Image
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param UploaderFactory $uploaderFactory
     * @param RequestDataInterface $requestData
     * @param Request $request
     * @param Filesystem $filesystem
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context              $context,
        Registry             $registry,
        ScopeConfigInterface $config,
        TypeListInterface    $cacheTypeList,
        UploaderFactory      $uploaderFactory,
        RequestDataInterface $requestData,
        Request              $request,
        Filesystem           $filesystem,
        AbstractResource     $resource = null,
        AbstractDb           $resourceCollection = null,
        array                $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $uploaderFactory,
            $requestData,
            $filesystem,
            $resource,
            $resourceCollection,
            $data
        );
        $this->request = $request;
    }

    /**
     * The tail part of directory path for uploading
     */
    public const UPLOAD_DIR = 'mageINIC/speaksearch';

    /**
     * Upload max file size in kilobytes
     *
     * @var int
     */
    protected $_maxFileSize = '2048';

    /**
     * Return path to directory for upload file
     *
     * @return string
     */
    protected function _getUploadDir(): string
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    /**
     * Makes a decision about whether to add info about the scope.
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo(): bool
    {
        return true;
    }

    /**
     * Getter for allowed extensions of uploaded files.
     *
     * @return string[]
     */
    protected function _getAllowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }

    /**
     * Get Tmp FileName
     *
     * @return mixed|null
     */
    protected function getTmpFileName()
    {
        $tmpName = null;
        $files = $this->request->getFiles()->toArray();
        if (isset($files['groups'])) {
            $tmpName = $files['groups'][$this->getGroupId()]['fields'][$this->getField()]['value']['tmp_name'];
        } else {
            if (isset($tmpName)) {
                $tmpName = is_array($this->getValue()) ? $this->getValue()['tmp_name'] : null;
            }
        }
        return $tmpName;
    }

    /**
     * Before Save Action
     *
     * @return $this
     * @throws LocalizedException
     */
    public function beforeSave(): Image
    {
        $value = $this->getValue();
        $deleteFlag = is_array($value) && !empty($value['delete']);
        $fileTmpName = $this->getTmpFileName();
        if ($this->getOldValue() && ($fileTmpName || $deleteFlag)) {
            $this->_mediaDirectory->delete(self::UPLOAD_DIR . '/' . $this->getOldValue());
        }
        return parent::beforeSave();
    }
}
