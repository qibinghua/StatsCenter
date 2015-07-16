<?php include __DIR__.'/../include/header.php'; ?>
<!-- END NAVIGATION -->

<!-- MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-title="refresh" rel="tooltip"
              data-placement="bottom"
              data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
              data-html="true"><i class="fa fa-refresh"></i></span> </span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Dashboard</li>
        </ol>

    </div>

    <div id="content">
        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-0"
                     data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>日志统计</h2>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
                    <div role="content">

                        <div class="jarviswidget-editbox">

                        </div>

                        <div class="widget-body no-padding">
                            <div class="widget-body-toolbar" style="height: 60px;">

                            </div>

                            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="dt-top-row">
                                    <div class="dataTables_filter" style="top:-56px">
                                        <form id="checkout-form" class="smart-form" novalidate="novalidate">
                                            <div class="form-group" style="width: 300px;">
                                                <select class="select2" id="module">
                                                    <option value="">所有模块</option>
                                                    <?php foreach ($modules as $m): ?>
                                                        <option value="<?= $m['id'] ?>: <?= $m['name'] ?>"
                                                            <?php if (isset( $_GET['module']) and $m['id'] == $_GET['module']) echo 'selected="selected"'; ?> ><?= $m['id'] ?>
                                                            : <?= $m['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group" style="width: 200px;">
                                                <?=$form['types']?>
                                            </div>
                                            <div class="form-group" style="width: 200px;">
                                                <?=$form['subtypes']?>
                                            </div>
                                            用户:
                                            <div class="form-group" style="width: 100px;">
                                                <label class="input">
                                                    <input type="text" name="uid" id="uid" placeholder="用户ID" value="<?=$this->value($_GET, 'uid')?>">
                                                </label>
                                            </div>
                                            IP:
                                            <div class="form-group" style="width: 120px;">
                                                <?php echo $form['clients']; ?>
                                            </div>
                                            <div class="form-group" style="width: 120px;">
                                                <select class="select2" id="level">
                                                    <option value="">日志等级</option>
                                                    <?php foreach ($this->log_level as $id => $m):
                                                        $_l = $id + 1;
                                                        ?>
                                                        <option value="<?= $_l ?>"
                                                            <?php if (isset($_GET['level']) and $_l == $_GET['level'])
                                                            {
                                                                echo 'selected="selected"';
                                                            } ?> ><?= $m ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            时间:
                                            <div class="form-group">

                                                <label class="select">
                                                    <select class="input-sm" id="filter_hour_s">
                                                        <option value='00' selected="selected">00</option>
                                                        <?php
                                                        for ($i = 1; $i < 24; $i++) {
                                                            $v = $i >= 10 ? $i : '0' . $i;
                                                            if (!empty($_GET['hour_start']) and $_GET['hour_start'] == $v)
                                                            {
                                                                echo "<option value='$v' selected='selected'>$v</option>\n";
                                                            } else {
                                                                echo "<option value='$v'>$v</option>\n";
                                                            }

                                                        }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                            -
                                            <div class="form-group">
                                                <label class="select">
                                                    <select class="input-sm" id="filter_hour_e">
                                                        <?php
                                                        for ($i = 0; $i < 23; $i++) {
                                                            $v = $i >= 10 ? $i : '0' . $i;
                                                            if (!empty($_GET['hour_end']) and $_GET['hour_end'] == $v)
                                                            {
                                                                echo "<option value='$v' selected='selected'>$v</option>\n";
                                                            } else {
                                                                echo "<option value='$v'>$v</option>\n";
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if (empty($_GET['hour_end']))
                                                        {
                                                            echo '<option value="23" selected="selected">23</option>';
                                                        }
                                                        ?>

                                                    </select>
                                                </label>
                                            </div>
                                            日期：
                                            <div class="form-group">
                                                <input type="text" class="form-control datepicker"
                                                       data-dateformat="yymmdd" id="data_key" style="width: 100px;"
                                                       readonly="readonly" value="<?= $_GET['date_key'] ?>"
                                                    />
                                            </div>
                                            <div class='form-group'>
                                                <a id='submit' class='btn btn-success' style='padding:6px 12px' href='javascript:void(0)'>查询日志</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table id="data_table_stats" class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>Time</th>
                                        <th>Type</th>
                                        <th>SubType</th>
                                        <th>UserId</th>
                                        <th>IP</th>
                                        <th>Content</th>
                                    </tr>
                                    </thead>
                                    <tbody id="data_table_body">
                                    <?php
                                    foreach ($logs as $d)
                                    {
                                        ?>
                                        <tr height="32">
                                            <td><?= $this->log_level[$d['level']] ?></td>
                                            <td><?= $d['addtime'] ?></td>
                                            <td><?= $d['type'] ?></td>
                                            <td><?= $d['subtype'] ?></td>
                                            <td><?= $d['uid'] ?></td>
                                            <td><?= $d['ip'] ?></td>
                                            <td><?= $d['content'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pager-box">
                            <?php echo $pager['render'];?>
                        </div>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

        </div>
        <div class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable" id="wid-id-1"
             data-widget-editbutton="false" role="widget" style="">


        </div>
        <div class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable" id="wid-id-2"
             data-widget-editbutton="false" role="widget" style="">

        </div>
        <div class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable" id="wid-id-3"
             data-widget-editbutton="false" role="widget" style="">

        </div>
        </article>
        <!-- WIDGET END -->
    </div>
</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
Note: These tiles are completely responsive,
you can add as many as you like
-->
<div id="shortcut">
    <ul>
        <li>
            <a href="#inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i
                        class="fa fa-envelope fa-4x"></i> <span>Mail <span
                            class="label pull-right bg-color-darken">14</span></span> </span> </a>
        </li>
        <li>
            <a href="#calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i
                        class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
        </li>
        <li>
            <a href="#gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i
                        class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
        </li>
        <li>
            <a href="#invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i
                        class="fa fa-book fa-4x"></i> <span>Invoice <span
                            class="label pull-right bg-color-darken">99</span></span> </span> </a>
        </li>
        <li>
            <a href="#gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i
                        class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span
                    class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
        </li>
    </ul>
</div>
<?php include dirname(__DIR__).'/include/javascript.php'; ?>
<script>
    $(function() {
        pageSetUp();
        var LogsG = {};
        LogsG.filter = <?php echo json_encode($_GET);?>;
        $("#datepicker").datepicker("option",
            $.datepicker.regional[ 'zh-CN' ]);

        $("#module").change(function(e) {
            var module = e.currentTarget.value.split(':')[0];
            window.localStorage.module_id = module;
            LogsG.filter.module = module;
            $("#client_ip").empty();
            LogsG.go();
        });
        $("#level").change(function (e) {
            LogsG.filter.level = level;
            LogsG.go();
        });
        $("#client_ip").change(function(e) {
            var client_ip = e.currentTarget.value;
            LogsG.filter.client_ip = client_ip;
        });
        $("#filter_hour_s").change(function(e) {
            LogsG.filter.hour_start = e.currentTarget.value;
            LogsG.go();
        });
        $("#filter_hour_e").change(function(e) {
            LogsG.filter.hour_end = e.currentTarget.value;
            LogsG.go();
        });
        $("#data_key").change(function() {
            LogsG.filter.date_key = $(this).val();

        });
        $("#submit").click(function(){
            LogsG.go();
        });
        LogsG.go = function() {
            LogsG.filter.uid = $("#uid").val();
            LogsG.filter.level = $("#level").val();
            var url = '/logs2/index/?';
            for (var o in LogsG.filter) {
                url += o + '=' + LogsG.filter[o] + '&';
            }
            location.href = url;
        };
        LogsG.getIpList = function(o) {
            $.ajax({
                url: "/logs/get_ip/?module_id="+LogsG.filter.module_id+"&interface_id="+LogsG.filter.interface_id,
                dataType : 'json',
                beforeSend:function() {
                    $("#client_ip").prev().children('.select2-choice').children('.select2-chosen').empty();
                    $("#client_ip").empty();
                },
                success: function(data) {
                    var line = '<option value="">请选择</option>';
                    if (data.status == 0) {
                        for (i = 0; i < data.client_ids.length; i++) {
                            line += '<option value="'+ data.client_ids[i] +'">' + data.client_ids[i] + '</option>';
                        }
                    }
                    $('#client_ip').html(line);
                }
            });
        }

        LogsG.getInterfaceList = function() {
            $.ajax({
                url: "/logs/get_interface/?module_id="+LogsG.filter.module_id,
                dataType : 'json',
                beforeSend:function() {
                    $("#interface_id").prev().children('.select2-choice').children('.select2-chosen').empty();
                    $("#interface_id").empty();
                },
                success: function(data) {
                    var line = '<option value="">请选择</option>';
                    if (data.status == 0) {
                        for (i = 0; i < data.interface_ids.length; i++) {
                            line += '<option value="'+ data.interface_ids[i]['id'] +'">' + data.interface_ids[i]['id']+':'+data.interface_ids[i]['name'] + '</option>';
                        }
                    }
                    $('#interface_id').html(line);
                }
            });
        }
        LogsG.filterByHour = function () {
            LogsG.filter.hour_start = $('#filter_hour_s').val();
            LogsG.filter.hour_end = $('#filter_hour_e').val();
        };
    });
</script>

</body>
</html>