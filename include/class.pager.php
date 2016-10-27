<?php

class pager {
    private $limit = 10;
    private $dlim1, $dlim2;
    private $record_count;
    private $page_count;
    private $query_string;
    private $page;
    private $max_showing_page;
    private $anchor = null;

    function pager($record_count, $limit = 20, $limit2 = 0) {
        $this->record_count = $record_count;
        $this->limit = &$limit;
        $this->dlim1 = $limit;
        $this->dlim2 = $limit2;
        if (isset($_GET['limit']) && ($_GET['limit'] == $limit || $_GET['limit'] == $limit2)) $_SESSION['pager_limit'] = $_GET['limit'];
        $limit = $_SESSION['pager_limit'] ? $_SESSION['pager_limit'] : $limit;

        $this->page_count = ceil($record_count / $limit);
        parse_str($_SERVER['QUERY_STRING'], $this->query_string);
        fi($this->query_string['page']);
        $this->page = $this->query_string['page'] ? $this->query_string['page'] : 1;
        if ($this->page < 1 || $this->page > $this->page_count) $this->page = 1;
    }

    function set_page($i) {
        $this->page = $i ? $i : $this->page;
        if ($this->page < 1 || $this->page > $this->page_count) $this->page = 1;
    }

    function getPagerLimitSelect() {
        return '<div class="pager-select"><select name="limitsel" onchange="location.href=\'' . $this->query_string . '&limit=\'+$(this).val();">
	        <option value="' . $this->dlim1 . '" ' . ($this->dlim1 == $this->limit ? ' selected="selected"' : '') . '>' . $this->dlim1 . '</option>
	        <option value="' . $this->dlim2 . '" ' . ($this->dlim2 == $this->limit ? ' selected="selected"' : '') . '">' . $this->dlim2 . '</option>
	    </select> Kayıt Göster</div>';
    }

    function set_max_showing_page($max_showing_page) {
        $this->max_showing_page = $max_showing_page;
    }

    function setLink($link) {
        $this->query_string = $link;
    }

    function setAnchor($id) {
        $this->anchor = $id;
    }

    function get_pager_as_select() {
        if ($this->page_count < 2) return;

        $link = is_array($this->query_string) ? a2q($this->query_string) : $this->query_string . '&';

        for ($i = 1; $i < $this->page_count + 1; $i++) {
            $h .= '<option value="' . $i . '" ' . ($this->page == $i ? 'selected' : '') . '>' . $i . '</a> ';
        }

        return $this->add_nav_buttons('<select name="" onchange="location.href=\'' . $link . '&page=\'+$(this).val()+\'' . $this->anchor . '\'">' . $h . '</select>');
    }

    function add_nav_buttons($out) {
        $link = is_array($this->query_string) ? a2q($this->query_string) : $this->query_string . '&';

        $res = $this->page > 1 ? '<li><a href="' . '?page=1' . $this->anchor . '" class="pager-nav">««</a></li><li><a href="' . '?page=' . ($this->page - 1 > 0 ? $this->page - 1 : 1) . $this->anchor . '" class="pager-nav">«</a></li> ' : '';
        $res .= $out;
        $res .= $this->page < $this->page_count ? '<li><a href="' . '?page=' . ($this->page + 1 < $this->page_count ? $this->page + 1 : $this->page_count) . $this->anchor . '" class="pager-nav">»</a></li><li><a href="' . '?page=' . ($this->page_count) . $this->anchor . '" class="pager-nav">»»</a></li>' : '';

        return $res;
    }

    function get_pager() {
        if ($this->page_count < 2) return;

        $link = is_array($this->query_string) ? a2q($this->query_string) : $this->query_string . '&';

        if ($this->max_showing_page && $this->max_showing_page < $this->page_count) {
            if (($this->page - ($this->max_showing_page / 2) >= 1)) {
                if ($this->page + ($this->max_showing_page / 2) <= $this->page_count) {
                    $start = $this->page - ($this->max_showing_page / 2);
                    $end = $this->page + ($this->max_showing_page / 2);
                } else {
                    $start = $this->page_count - $this->max_showing_page;
                    $end = $this->page_count;
                }
            } else {
                $start = 1;
                $end = $this->max_showing_page;
            }

            for ($i = $start; $i < $end + 1; $i++) {
                if ($this->page == $i) $h .= '<li class="active"><a>' . $i . '</a></li>';
                else $h .= '<li><a href="' . '?page=' . $i . $this->anchor . '">' . $i . '</a></li>';
            }

            //$h = $this->add_nav_buttons($h);
        } else {
            for ($i = 1; $i < $this->page_count + 1; $i++) {
                if ($this->page == $i) $h .= '<li class="active"><a>' . $i . '</a></li>';
                else $h .= '<li><a href="' . '?page=' . $i . $this->anchor . '">' . $i . '</a></li>';
            }
        }

        return '<div class="pagination"><ul>' . $this->add_nav_buttons($h) . '</ul></div>';
    }

    function get_sql_limit() {
        return ' limit ' . (($this->page - 1) * $this->limit) . ',' . $this->limit . '';
    }

    public function get_record_start() {
        return (($this->page - 1) * $this->limit) + 1;
    }

    public function get_record_end() {
        return $this->page_count == $this->page ? $this->record_count : $this->page * $this->limit;
    }
}

?>