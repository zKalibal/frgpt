<?php
session_start();
if ($_GET['token'] == "1734e107657db73f925e1e5a535efd85") {
    include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

    //DELETE ALL SUPPORTERS
    security_query("DELETE FROM fr_patreon_supporters", []);

    //GET TIERS
    $tiers = curl_call(
        'https://www.patreon.com/api/oauth2/v2/campaigns/11608412?include=tiers&fields%5Bcampaign%5D=creation_name&fields%5Btier%5D=title%2Cpatron_count%2Camount_cents',
        $method = "GET",
        $header = array(
            "Authorization: Bearer cpUD_BlkZlAP6VrCc4ajU5_0RAvhIydSioA9wb5b8bA"
        )
    )['included'];

    //GET SUPPORTERS
    $supporters = [];
    $next = "";
    while ($next !== false) {
        $r = curl_call(
            'https://www.patreon.com/api/oauth2/v2/campaigns/11608412/members?include=currently_entitled_tiers%2Cuser&fields%5Bmember%5D=email%2Cpatron_status%2Cpledge_cadence%2Cpledge_relationship_start%2Clifetime_support_cents%2Cfull_name%2Ccampaign_lifetime_support_cents&fields%5Buser%5D=full_name%2Cvanity' . $next,
            $method = "GET",
            $header = array(
                "Authorization: Bearer cpUD_BlkZlAP6VrCc4ajU5_0RAvhIydSioA9wb5b8bA"
            )
        );
        $supporters = array_merge($supporters, $r['data']);
        $next = ($r['meta']['pagination']['cursors']['next'] != null) ? "&page%5Bcursor%5D=" . $r['meta']['pagination']['cursors']['next'] : false;
    }

    //INSERT SUPPORTERS
    foreach ($supporters as $key => $value) {
        $tier = $tiers[array_search(end($value['relationships']['currently_entitled_tiers']['data'])['id'], array_column($tiers, 'id'))];
        $v = $value['attributes'];
        $v['tier'] = $tier['attributes']['title'];
        $v['tier_id'] = $tier['id'];
        foreach ($v as $k => $val) {
            ($val == '') ? $v[$k] = 'NULL' : (is_string($val) ? $v[$k] = '"' . $val . '"' : $val);
        }
        $values .= "('{$value['id']}',{$v['campaign_lifetime_support_cents']},{$v['email']},{$v['full_name']},{$v['lifetime_support_cents']},{$v['patron_status']},{$v['pledge_cadence']},{$v['pledge_relationship_start']},{$v['tier']},{$v['tier_id']}),";
    }
    security_query("INSERT INTO fr_patreon_supporters (id,campaign_lifetime_support_cents,email,full_name,lifetime_support_cents,patron_status,pledge_cadence,pledge_relationship_start,tier,tier_id) VALUES " . trim($values, ','), []);
}
