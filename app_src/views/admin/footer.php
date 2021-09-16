<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<footer class="main-footer">
  <div class="footer-left">
    <a href="#" class="text-warning">MbanguPay</a></a>
  </div>
</footer>
<script src="<?php echo base_url() . 'assets/js/app.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/owlcarousel2/dist/owl.carousel.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/page/owl-carousel.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/scripts.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/custom.js'; ?>"></script>

<script src="<?php echo base_url() . 'assets/bundles/fullcalendar/fullcalendar.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/page/calendar.js'; ?>"></script>

<link rel="stylesheet" href="<?= base_url('/') ?>assets/bundles/datatables/datatables.min.css">

<script src="<?php echo base_url() . 'assets/js/page/index.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/datatables.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/export-tables/dataTables.buttons.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/export-tables/buttons.flash.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/export-tables/jszip.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/export-tables/pdfmake.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/apexcharts/apexcharts.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/export-tables/vfs_fonts.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/bundles/datatables/export-tables/buttons.print.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/page/datatables.js'; ?>"></script>

<div class="modal fade" id="modal-token" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="f-token" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Token twilio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div date-token></div>
          </div>
          <input class="form-control" placeholder="Token" disabled type="text" name="token" value="" required>
          <p tmsg></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <button disabled type="submit" class="btn btn-danger">Mettre a jour</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(function() {
    mt = $('#modal-token');
    ft = $('#f-token');
    btn = $('.token');
    msg = $('[tmsg]');
    var today = new Date('<?= date('Y-m-d H:i:s') ?>');

    btn.click(function() {
      msg.html('');
      mt.modal();
      $.getJSON("<?= site_url('sms/token') ?>", {
        type: 'admin'
      }, function(d) {
        $("input[name=token]", ft).val(d.token);
        $(":input", ft).attr('disabled', false);

        date = new Date(d.date);
        expire = addHours(date, 23);
        var time = expire.getTime() - today.getTime();
        time = time / (1000 * 3600 * 24);
        expire = expire.getDate() + "-" + (expire.getMonth() + 1) + "-" + expire.getFullYear() + " " +
          expire.getHours() + ":" + expire.getMinutes();

        if (time < 0) {
          l = `<b class='text-danger' >Token expiré</b>`;
        } else {
          l = ` Expire ${expire}`;
        }

        var m = `${d.date} | ${l}`
        $('[date-token]').html(m);

      })
    });

    function addHours(date, hours) {
      const newDate = new Date(date);
      newDate.setHours(newDate.getHours() + hours);
      return newDate;
    }


    ft.submit(function(e) {
      e.preventDefault();
      msg.html('');
      var data = 'type=admin&' + ft.serialize();
      $(":input", ft).attr('disabled', true);
      $.post("<?= site_url('sms/token') ?>", data, function(d) {
        d = JSON.parse(d);
        $("input[name=token]", ft).val(d.token);
        $(":input", ft).attr('disabled', false);
        msg.html(d.message);

        date = new Date(d.date);
        expire = addHours(date, 23);
        var time = expire.getTime() - today.getTime();
        time = time / (1000 * 3600 * 24);
        expire = expire.getDate() + "-" + (expire.getMonth() + 1) + "-" + expire.getFullYear() + " " +
          expire.getHours() + ":" + expire.getMinutes();

        if (time < 0) {
          l = `<b class='text-danger' >Token expiré</b>`;
        } else {
          l = ` Expire ${expire}`;
        }

        var m = `${d.date} | ${l}`

        $('[date-token]').html(m);

      })
    })
  })
</script>