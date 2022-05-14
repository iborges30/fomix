<?php


namespace Source\App\Admin;


use Source\Models\Clients\Clients;
use Source\Models\Orders\Orders;
use Source\Support\Pager;

class ReportsController extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function home(?array $data): void
    {   
        $enterprise_id = user()->enterprise_id;
        if(!empty($_POST)){
            $startDate = $data['start_date']??'';
            $endDate = $data['end_date']??'';
            $status = $data['status']??'';
            echo json_encode(['redirect'=>url("/admin/reports/home&start_date={$startDate}&end_date={$endDate}&status={$status}")]);
            die();
        }
        $startDate = $_GET['start_date']??null;
        $endDate = $_GET['end_date']??null;
        $status = $_GET['status']??null;
        $buildSql = '';

        if($startDate && $endDate && !$status)
        {
            $buildSql = "enterprise_id = :di AND created BETWEEN :startDate AND :endDate";
            $orders = (new Orders())->has(Clients::class, "client_id")->find($buildSql,"di={$enterprise_id}&startDate={$this->formatDateToSql($startDate,'0 day')}&endDate={$this->formatDateToSql($endDate, '+1 day')}");
        }
        else if($startDate && $endDate && $status)
        {
            $buildSql = "enterprise_id = :di AND created BETWEEN :startDate AND :endDate AND status = :status";
            $orders = (new Orders())->has(Clients::class, "client_id")->find($buildSql,"di={$enterprise_id}&startDate={$this->formatDateToSql($startDate,'0 day')}&endDate={$this->formatDateToSql($endDate,'+1 day')}&status={$status}");
        }
        else if(!$startDate && !$endDate && $status)
        {
            $buildSql .= "enterprise_id = :di AND status = :status";
            $orders = (new Orders())->has(Clients::class, "client_id")->find($buildSql,"di={$enterprise_id}&status={$status}");

        }else{
            $orders = (new Orders())->has(Clients::class, "client_id")->find("enterprise_id = :di","di={$enterprise_id}");
        }
        
        $pager = new Pager(url("/admin/reports/home/"));
        $pager->pager($orders->count(), 50, (!empty($data["page"]) ? $data["page"] : 1));
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Relatório de Pedidos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/reports/home", [
            "app" => "reports/home",
            "head" => $head,
            "orders" => $orders->limit($pager->limit())->offset($pager->offset())->order("created DESC, status ASC")->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    private function formatDateToSql($date, $days='')
    {
        return date('Y-m-d', strtotime(str_replace('/','-',$date).$days));
    }
}
