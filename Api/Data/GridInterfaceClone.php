<?php

namespace Webkul\Grid\Api\Data;

interface GridInterfaceClone
{
    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';
    const OLD_ENTITY_ID = 'old_entity_id';
    const CONTENT = 'content';
    const PUBLISH_DATE = 'publish_date';
    const IS_ACTIVE = 'is_active';
    const UPDATE_TIME = 'update_time';
    const CREATED_AT = 'created_at';

    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId);

    /**
     * Get OLDEntityId.
     *
     * @return varchar
     */
    public function getOldEntityId();

    /**
     * Set EntityId.
     */
    public function setOldEntityId($OldentityId);

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getTitle();

    /**
     * Set Title.
     */
    public function setTitle($title);

    /**
     * Get Content.
     *
     * @return varchar
     */
    public function getContent();

    /**
     * Set Content.
     */
    public function setContent($content);

    /**
     * Get Publish Date.
     *
     * @return varchar
     */
    public function getPublishDate();

    /**
     * Set PublishDate.
     */
    public function setPublishDate($publishDate);

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive();

    /**
     * Set StartingPrice.
     */
    public function setIsActive($isActive);

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime();

    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime);

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt();

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt);
}