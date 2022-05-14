<?php


namespace Source\Models\Feed;


use Source\Core\Model;

class Feed extends Model
{
    public function __construct()
    {
        parent::__construct("feed", ["id"], []);
    }

    public function feed(string $citySlug, int $limit)
    {
        $feed = (new Feed())->findCustom("       SELECT
	feed.description, 
	feed.id, 
	feed.image, 
	enterprises.enterprise, 
	enterprises.slug, 
	enterprises.image as profile
FROM
	feed,
	enterprises
WHERE
	feed.enterprise_id = enterprises.id AND
    enterprises.slug_city = :city", "city={$citySlug}")->order("feed.created DESC")->limit($limit)->fetch(true);

        if ($feed) {
            return $feed;
        }
    }

}