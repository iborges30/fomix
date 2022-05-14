<?php


namespace Source\App\Admin;


use Source\Models\Feed\Feed;
use Source\Models\FeedGallery\FeedGallery;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

class FeedController extends Admin
{
    /**
     * Control constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function home(?array $data): void
    {
        $user = user();
        $feed = (new Feed())->find("enterprise_id = :d", "d={$user->enterprise_id}");
        $pager = new Pager(url("/admin/feed/home/"));
        $pager->pager($feed->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . "Meus posts",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/feed/home", [
            "app" => "feed/home",
            "head" => $head,
            "feed" => $feed->order("created DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }


    public function show(?array $data): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . "Meus posts",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/feed/create", [
            "app" => "flavors/home",
            "head" => $head,

        ]);
    }

    public function create(?array $data): void
    {
        $user = user();
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $create = new Feed();

            $create->enterprise_id = $user->enterprise_id;
            $create->user_id = $user->id;
            $create->description = $data["description"] ?? 'fomix';
            $create->uuid = createdUniversalIdentifier();
            $create->created = date("Y-m-d H:i:s");

            //upload cover
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, "fomix-" . time());

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $create->image = $image;
            }


            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Post salvo com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/feed/create/{$create->uuid}")]);
            return;
        }
    }

    public function edit(?array $data): void
    {
        $feedUuid = filter_var($data["id"], FILTER_SANITIZE_STRING);
        $feed = (new Feed())->find("uuid = :di", "di={$feedUuid}")->fetch();

        $head = $this->seo->render(
            CONF_SITE_NAME . "Meus posts",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/feed/create", [
            "app" => "flavors/home",
            "head" => $head,
            "feed" => $feed
        ]);
    }


    public function update(?array $data): void
    {
        $feedUuid = filter_var($data["id"], FILTER_SANITIZE_STRING);
        $update = (new Feed())->find("uuid = :di", "di={$feedUuid}")->fetch();

        if (!$update) {
            $this->message->error("Você tentou editar um post que não existe ou foi removido")->flash();
            echo json_encode(["redirect" => url("/admin/feed/home")]);
            return;
        }

        $update->description = $data["description"] ?? 'fomix';
        $update->lastupdate = date("Y-m-d H:i:s");

        //upload cover
        if (!empty($_FILES["image"])) {
            $files = $_FILES["image"];
            $upload = new Upload();
            $image = $upload->image($files, "fomix-". time());

            if (!$image) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }

            $update->image = $image;
        }

        if (!$update->save()) {
            $json["message"] = $update->message()->render();
            echo json_encode($json);
            return;
        }


        $json["message"] = $this->message->success("Post atualizado com sucesso...")->render();
        echo json_encode($json);
        return;

        $head = $this->seo->render(
            CONF_SITE_NAME . "Editar post",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/feed/create", [
            "app" => "flavors/home",
            "head" => $head
        ]);
    }

    public function delete(?array $data):void{
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new Feed())->findById($data["post_id"]);


            if (!$delete) {
                $this->message->error("Você tentnou deletar um post que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/feed/home")]);
                return;
            }

            if ($delete->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$delete->image}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$delete->image}");
                (new Thumb())->flush($delete->image);
            }

            $delete->destroy();

            $this->message->success("O post foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/feed/home")]);

            return;
        }
        
        
    }
}