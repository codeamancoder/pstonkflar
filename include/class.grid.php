<?php

class grid {
    const _STRING = 'string';
    const _ICON = 'icon';
    const _LINK = 'link';
    const DATETIME = 'datetime';
    const DATE = 'date';
    const DATES = 'dates';
    const COLOR = 'color';
    const MONEY = 'money';
    const _ARRAY = 'array';
    const _SELECT = 'select';
    const CHECK = 'check';
    const DYNICON = 'dynicon';
    const FOTO = 'foto';

    private $data = null;
    private $title = null;
    private $confIcon = '';
    private $info = '';

    public $_sql = null;

    private $_lineCount = null;
    private $_pageCount = null;
    private $_activePage = null;
    private $_queryLimit = null;
    private $_ifempty = null;
    private $_buttons = null;
    private $_line_id = false;
    private $_sortableTarget = false;
    private $_searchLink = '';
    private $_rowformat = null;

    private $_LPP = 0;
    private $_defLPP = 25;
    private $_LPPLimits = array(25 => 25, 50 => 50, 100 => 100, 'Hepsi' => 100000);

    private $_class = '';

    public $session = false;

    public $search = null;

    function grid() {
        $this->id = uniqid();
        $this->search = new datafilter();
    }

    function setClass($c) {
        $this->_class = ' ' . $c . ' ';
    }

    function query($q, $order = '', $dir = '') {
        $q = $this->search->init($q);
        $this->_searchLink = $this->search->getLink();
        $this->_query = $q;
        $this->_queryOrderBy = isset($_GET['ob']) && ($ob = $_GET['ob']) ? ' order by ' . $ob : (isset($_GET['obd']) && ($ob = $_GET['obd']) ? ' order by ' . $ob . ' desc' : ($order ? ' order by ' . $order . ($dir ? ' desc' : '') : ''));
        $this->_defOrderBy = $order;
        $this->_defOrderDir = $dir ? 'd' : '';
    }

    function setData($data) {
        $this->data = $data;
    }

    function addCol($a) {
        $this->cols[$a['name']] = $a;
    }

    function addRowFormat($a) {
        $this->_rowformat = $a;
    }

    function addIcon($a) {
        $this->icon[$a['title']] = $a;
    }

    function setLink($link) {
        $this->link = $link;
        $this->search->link = $link;
    }

    function addButton($title, $link, $class = 'new') {
        $this->_buttons[] = '<a href="' . $link . '" class="' . $class . ' btn btn-small"><i class="icon-plus"></i> ' . $title . '</a>';
    }

    function addInfo($info = '') {
        $this->info .= $info;
    }

    function addTopIcon($a) {
        $this->confIcon .= '<a href="' . $this->link . $a['link'] . '" class="' . $a['class'] . '" title="' . $a['title'] . '">' . $a['value'] . '</a>';
    }

    function ifempty($v) {
        $this->_ifempty = $v;
    }

    function addPager($line = 0) {
        $queryCount = preg_replace('/^SELECT (.*)[\ \r\n\t]*FROM/', 'select count(*) from', $this->_query);

        if (isset($_REQUEST['lpp']) && in_array($_REQUEST['lpp'], $this->_LPPLimits) && ($this->_LPP = $_GET['lpp'])) $_SESSION['grid']['lpp'] = $this->_LPP;
        elseif (!empty($_SESSION['grid']['lpp'])) $this->_LPP = $_SESSION['grid']['lpp'];
        elseif ($line) $this->_LPP = $line;

        $this->_lineCount = factory::get('datalayer')->sorgu($queryCount)->sonuc(0);
        $this->_pageCount = ceil($this->_lineCount / $this->_LPP);
        $this->_activePage = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
        $this->_queryLimit = ' limit ' . $this->_activePage * $this->_LPP . ',' . $this->_LPP;
    }

    function setLineId($id) {
        $this->_line_id = $id;
    }

    function setRow($a) {
        $this->_row = $a;
    }

    function sortable($link) {
        $this->_sortableTarget = $link;
    }

    function getBody() {
        $worder = array('d' => 'up', 'u' => 'down');
        if ($this->_query) $this->data = factory::get('datalayer')->sorgu($this->_query . ' ' . $this->_queryOrderBy . ' ' . $this->_queryLimit)->liste();
        foreach ($this->cols as $k => $v) {

            $img = isset($_GET['ob']) && ($_GET['ob'] == $v['name']) ? ' <i class="icon-chevron-down"></i>' : (isset($_GET['obd']) && ($_GET['obd'] == $v['name']) ? ' <i class="icon-chevron-up"></i>' : (!isset($_GET['ob']) && !isset($_GET['obd']) && $this->_defOrderBy == $v['name'] && ($_GET['ob' . $this->_defOrderDir] = $v['name']) ? '<i class="icon-chevron-' . $worder[$this->_defOrderDir] . '">' : ''));
            $it = isset($v['sort']) && $v['sort'] ? '<a href="' . $this->link . '&' . (isset($_GET['ob']) && ($_GET['ob'] == $v['name']) ? 'obd' : 'ob') . '=' . $k . $this->_searchLink . '">' . $v['title'] . $img . '</a>' : ($v['type'] == 'icon' ? '' : $v['title']);
            $it = $v['type'] == self::CHECK ? '<input type="checkbox" id="ckeckall">' : $it;
            $title .= '<th' . (isset($v['width']) ? ' width="' . $v['width'] . '"' : '') . ' class="' . ($v['type'] == grid::MONEY ? (isset($v['class']) ? $v['class'] : 'sag') : '') . '">' . $it . '</th>';
        }

        $this->title = '<tr>' . $title . '</tr>';

        if ($this->data) {
            foreach ($this->data as $key => $value) {
                foreach ($this->cols as $k => $v) {
                    switch ($v['type']) {
                        case self::_ARRAY:
                            $line .= '<td>' . $v['array'][$value[$k]] . '</td>';
                            break;

                        case self::_ICON:
                            $v['link'] = aprintf($v['link'], $value);
                            if (isset($v['dynClass'])) $v['dynClass'] = @aprintf($v['dynClass'], $value);
                            if (isset($v['ifClass'])) $v['ifClass']($v, $value);

                            $line .= '<td class="icon">
										<a href="' . $v['link'] . (isset($_GET['obd']) ? '&obd=' . $_GET['obd'] : '') . (isset($_GET['ob']) ? '&ob=' . $_GET['ob'] : '') . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '"' .
                                (isset($v['rel']) ? ' rel="' . $v['rel'] . '"' : '') . '
										  class="' . (isset($v['class']) ? $v['class'] : '') . $v['dynClass'] . '"
										  ' . (isset($v['extra']) ? $v['extra'] : '') . '
										  title="' . $v['title'] . '"
										  ' . (isset($v['confirm']) ? 'onclick="return confirm(\'' . $v['confirm'] . '\')"' : '') . '
										  ' . (isset($v['prompt']) ? ' onclick="return jsdogrula();"' : '') . '>
										</a>
									  </td> ';
                            break;

                        case 'multi':
                            $a = aprintf($v['value'], $value);
                            $line .= '<td>' . aprintf($v['value'], $value) . ' </td> ';
                            break;

                        case self::DATETIME:
                            $line .= '<td>' . date('H:i:s d.m.Y', strtotime($value[$k])) . '</td>';
                            break;

                        case 'foto':
                            $line .= '<td><img src="/user/files/thumb_' . $value[$k] . '"></td>';
                            break;

                        case self::DATE:
                            $line .= '<td>' . date('d.m.Y', strtotime($value[$k])) . '</td>';
                            break;

                        case self::DATES:
                            $tv = array();
                            foreach ($v['vals'] as $t) $tv[] = date('d.m.Y', strtotime($value[$t]));
                            $line .= '<td>' . implode('<br>', $tv) . '</td>';
                            break;

                        case self::COLOR:
                            $line .= '<td><div ' . ($value[$k] ? ' style="background-color:' . $value[$k] . ';width:30px;height:30px;"' : '') . '></div></td>';
                            break;

                        case self::MONEY:
                            $line .= '<td class="' . (isset($v['class']) ? $v['class'] : 'sag') . '">' . number_format($value[$k], 2) . (isset($v['currency']) ? ' ' . $v['currency'] : '') . '</td>';
                            break;

                        case self::_SELECT:
                            $attr = $v['attr'] ? aprintf($v['attr'], $value, ' %s') : '';
                            $line .= '<td' . $attr . '>' . html::selecta($v['array'], $v['name'], $value[$k]) . '</td>';
                            break;

                        case 'mektup':
                            $line .= '<td>
							    <center>' . ($value['mektup_id'] ? '<a href="?b=isveren/mektup/giden&id=' . $value['mektup_id'] . '" class="dialog" title="Gönderilen Mektup"><img src="/static/images/mektup' . $value['mektup_durum'] . '.png"></a><br>' . date('d.m.Y', strtotime($value['tarih_gonderme'])) : '') . '</center>
							</td>';
                            break;

                        case 'adaybilgi':
                            $line .= '<td>
							    <a href=# onclick="window.open(\'?b=isveren/cv&id=' . $value['cv_id'] . '\',\'#' . $value['id'] . '\',\'width=950,height=700,scrollbars=1\'); return false;">' . $value['ad'] . ' ' . $value['soyad'] . '</a> (' . $value['yas'] . ')<br>
                                ' . ($value['calisma_durumu'] ? '<span>' . $value['son_is'] . '</span><br>' : '') . '
                                <i>' . $value['ulke'] . '</i> - <i>' . $value['sehir'] . '</i><br>
                                <span>' . $value['son_okul'] . '</span>
							</td>';
                            break;

                        case self::CHECK:
                            $line .= '<td><input type="checkbox" id="' . $value['name'] . '_' . $val . '" name="' . $value['name'] . '_' . $val . '" value="' . $val . '"></td>';
                            break;

                        case self::_LINK:

                            $val = !empty($v['value']) ? $v['value'] : $value[$k];
                            $prefix = !empty($v['prefix']) ? $v['prefix'] : '';
                            $suffix = !empty($v['suffix']) ? $v['suffix'] : '';
                            $val = $prefix . $val . $suffix;

                            if (isset($v['if'])) {
                                $yt = 1;
                                $params = @split(',', $v['if']);
                                foreach ($params as $param) $yt &= $value[$param];

                                if (!$yt) {
                                    $line .= '<td>' . $val . '</td>';
                                    break;
                                }
                            }

                            $v['link'] = aprintf($v['link'], $value);

                            $line .= '<td><a href="' . $v['link'] . '"' . (isset($v['rel']) ? ' rel="' . $v['rel'] . '"' : '') . (isset($v['extra']) ? ' ' . $v['extra'] : '') . '>' . $val . '</td>';

                            break;
                        default :

                            $line .= '<td>' . (isset($v['maxsize']) && strlen($value[$k]) > $v['maxsize'] ? '<a title="' . $value[$k] . '">' . mb_substr($value[$k], 0, $v['maxsize'], 'utf8') . '...</a>' : $value[$k]) . '</td>';
                            break;
                    }
                }
                $lines .= '<tr' . ($this->_line_id ? ' id="' . aprintf($this->_line_id, $value) . '"' : '') . (!empty($this->_row) ? aprintf($this->_row, $value) : '') . '>' . $line . '</tr>';
                $line = '';
            }
        } else $lines = '<tr><td colspan="' . count($this->cols) . '" class="empty">' . $this->_ifempty . '</td></tr>';

        if ($this->_sortableTarget) {
            $sort = factory::get('js')->add("$('.grid.sortable tbody').sortable({items:'tr', axis: 'y',helper:function(e, ui) {ui.children().each(function() { $(this).width($(this).width()); });return ui },stop:function(){
				var a = $('.grid.sortable tbody tr').map(function(){
					return $(this).attr('id').split('_')[1];
				}).get().join(',');
				$.get('" . $this->_sortableTarget . "'+a);
		}});")->ready()->getAll();
            $this->_class .= ' sortable';
        }

        return '<table class="table' . $this->_class . '">
					<thead>' . $title . '</thead>
					<tbody>' . $lines . '</tbody>
				</table>' . $sort;
    }

    function getTop($show_buttons = false) {
        //if($this->_lineCount < 25 ) return '';

        $buttons = !empty($this->_buttons) && $show_buttons ? '<div class="buttons">' . implode(' ', $this->_buttons) . '</div>' : '';

        if ($this->_LPP) {

            $orderBy = (isset($_GET['ob']) ? '&ob=' . $_GET['ob'] : '') . (isset($_GET['obd']) ? '&obd=' . $_GET['obd'] : '');

            foreach ($this->_LPPLimits as $p => $v) {
                $o1 .= '<option value="' . $v . '"' . ($v == $this->_LPP ? ' selected="selected"' : '') . '>' . $p . '</option>';
            }
            $o .= '<select name="lpp" onchange="location.href=\'' . $this->link . $orderBy . '&lpp=\'+this.value"> ' . $o1 . '</select>';

            if ($this->_lineCount > $this->_LPP) {
                $pg = $this->_activePage > 0 ? '<span><a href="' . $this->link . $orderBy . '&page=0">|<</a></span><span><a href="' . $this->link . '&page=' . ($this->_activePage - 1) . $orderBy . $this->_searchLink . '"><</a></span>' : '<span class="p">|<</span><span class="p"><</span>';

                for ($i = 0; $i < $this->_pageCount; $i++) {
                    $o2 .= '<option value="' . $i . '"' . ($i == $this->_activePage ? ' selected="selected"' : '') . '>' . ($i + 1) . '</option>';
                }
                $pg .= ' Sayfa : <select name="page" onchange="location.href=\'' . $this->link . $orderBy . '&page=\'+this.value' . $this->_searchLink . '">' . $o2 . '</select> / ' . $this->_pageCount;
                $pg .= ' &nbsp&nbsp(' . ($this->_activePage * $this->_LPP + 1) . ' - ' . ($this->_activePage + 1 < $this->_pageCount ? ($this->_activePage + 1) * $this->_LPP : $this->_lineCount) . ' / ' . $this->_lineCount . ') ';

                $pg .= $this->_activePage < $this->_pageCount - 1 ? '<span><a href="' . $this->link . '&page=' . ($this->_activePage + 1) . $orderBy . $this->_searchLink . '">></a></span><span><a href="' . $this->link . '&page=' . ($this->_pageCount - 1) . $orderBy . $this->_searchLink . '">>|</a></span>' : '<span class="p"> > </span> <span class="p"> >| </span>';
            }
            $this->pager = '<div class="grid-pager">Kayıt Sayısı:' . $o . $pg . '</div>';
        }

        return '<div class="grid-top">' . $buttons . '<form name="gform" action="' . $this->link . '" method="get">' . $this->confIcon . $this->pager . '</form></div>';
    }

    function run_ajax($p) {
        if (($c = getRequest('o', 1)) == 'getbody') {
            if (isset($p['lpp'])) {

                $this->addPager($p['lpp']);

            }

            exit(json_encode(array('.grid' => $this->getBody())));
        }
    }

}

class datafilter {
    public $rows = array();
    public $id;
    private $_active = false;
    private $_form = false;
    private $_nid = false;
    public $link = '';

    function datafilter() {
        if ($id = $_POST['s']) {
            unset($_SESSION['grid']['form']);
            $_SESSION['grid']['form'][$id] = $_REQUEST;
            $this->_form = $_REQUEST;
        } elseif ($id = $_GET['s']) {
            $this->_form = $_SESSION['grid']['form'][$id];
        } else {
            $id = uniqid();
        }

        $this->id = $id;
    }

    function getLink() {
        return $this->_active ? '&s=' . $this->id : '';
    }

    function add($array) {
        $this->rows[$array['name']] = $array;
    }

    function init($q) {
        if ($this->rows) {
            if (!$this->_form && (@count(@array_intersect_key($this->rows, $_REQUEST)))) $this->_form = $_REQUEST;

            foreach ($this->rows as $k => $v) {
                $th .= '<th>' . $v['title'] . '</th>';

                if ($this->_form[$k]) {
                    $this->_active = 1;
                    $v['value'] = $this->_form[$k];
                }

                switch ($v['type']) {
                    case 'equal' :
                        if ($this->_form[$k]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k='" . $v['value'] . "'";
                        $td .= '<td class="' . $v['class'] . '"><input type="text" name="' . $v['name'] . '" value="' . $v['value'] . '"></td>';
                        break;

                    case 'date' :
                        if ($this->_form[$k][0] && $this->_form[$k][1]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k BETWEEN '" . todbdate($v['value'][0]) . "' AND '" . todbdate($v['value'][1]) . "'";
                        elseif ($this->_form[$k][0]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k>'" . todbdate($v['value'][0]) . "'";
                        elseif ($this->_form[$k][1]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k<'" . todbdate($v['value'][1]) . "'";
                        $td .= '<td class="' . $v['class'] . '"><input type="text" name="' . $v['name'] . '[0]" value="' . $v['value'][0] . '" class="date"> - <input type="text" name="' . $v['name'] . '[1]" value="' . $v['value'][1] . '" class="date"></td>';

                        break;

                    case 'like' :
                        if ($this->_form[$k]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k like '%" . $v['value'] . "%'";
                        $td .= '<td class="' . $v['class'] . '"><input type="text" name="' . $v['name'] . '" value="' . $v['value'] . '"></td>';
                        break;

                    case 'listbox' :
                        if (isset($this->_form[$k]) && ($this->_form[$k] !== '')) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k='" . $v['value'] . "'";
                        $td .= '<td>' . $v['component'] . '</td>';
                        break;

                    case 'between' :
                        if ($this->_form[$k][0] && $this->_form[$k][1]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k BETWEEN '" . $v['value'][0] . "' AND '" . $v['value'][1] . "'";
                        elseif ($this->_form[$k][0]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k>'" . $v['value'][0] . "'";
                        elseif ($this->_form[$k][1]) $sql .= " AND " . ($v['prefix'] ? $v['prefix'] . '.' : '') . "$k<'" . $v['value'][1] . "'";
                        $td .= '<td class="bw ' . $v['class'] . '"><input type="text" name="' . $v['name'] . '[0]" value="' . $v['value'][0] . '"> - <input type="text" name="' . $v['name'] . '[1]" value="' . $v['value'][1] . '"></td>';
                        break;

                    default :
                        $td .= '<td class="' . $v['class'] . '"><input type="text" name="' . $v['name'] . '" value="' . $v['value'] . '"></td>';
                        break;

                }

//				if($this->_form[$k]) 
//				{
//					$v['value'] = $this->_form[$k];
//					if($v['type']=='like') $sql .= " AND ".($v['prefix']?$v['prefix'].'.':'')."$k like '%".$v['value']."%'"; 
//					elseif($v['type']=='equal' || $v['type']=='listbox') $sql .= " AND ".($v['prefix']?$v['prefix'].'.':'')."$k='".$v['value']."'";
//
//					$this->_active = 1;
//				}
//				
//				
//				if($v['type'] == 'listbox') {
//					$td .= '<td>'.$v['component'].'</td>';
//				}
//				elseif($v['type'] == 'between') {
//					$td .= '<td class="bw '.$v['class'].'"><input type="text" name="'.$v['name'].'[0]" value="'.$v['value'][0].'"> - <input type="text" name="'.$v['name'].'[1]" value="'.$v['value'][1].'"></td>';					
//				}
//				else {
//					$td .= '<td class="'.$v['class'].'"><input type="text" name="'.$v['name'].'" value="'.$v['value'].'"></td>';
//				}

            }

//			if($i==1) $lines .= '<tr>'.$line.'<th></th><td></td></tr>';

            $this->_out = '<div class="grid-arama"><table><tr>' . $th . '<th></th></tr><tr>' . $td . '<td><a href="ara" class="find" onclick="document.frmedit.submit();return false;"><i class="icon-search"></i> Arama Yap</a> <a href="' . $this->link . '" class="clear"><i class="icon-retweet"></i> Temizle</a><input type="submit" name="ara" class="gizli"><input type="hidden" name="s" value="' . uniqid() . '"></td></tr></table></div>';

            return preg_replace('/\{filter\}/', $sql, $q);
        }
        return $q;
    }

    function getBody() {
        return $this->_out;
    }

    function get($k) {
        return !empty($this->_form[$k]) ? $this->_form[$k] : $_REQUEST[$k];
    }
}