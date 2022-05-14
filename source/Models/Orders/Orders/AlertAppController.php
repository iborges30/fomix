<?php


namespace Source\App\Admin;


use Source\Models\Orders\Orders;

class AlertAppController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function alert(): void
    {
        $alertApp = (new Orders())->find(" status = :st AND notification = :a", "st=1&a=open");
        if ($alertApp->count() >= 1) {
            $json['count'] = $alertApp->count();
            echo json_encode($json);
        }
    }

    public function finish(?array $data): void
    {
        $notification = (new Orders())->find("status = :st AND notification = :a", "st=1&a=open")->fetch(true);

        if ($notification) {
            foreach ($notification as $p) {
                $p->notification = "viewed";
                $p->save();
            }
            $json['viewed'] = true;
            echo json_encode($json);
        }
    }
}