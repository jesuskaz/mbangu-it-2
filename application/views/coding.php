<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Remove Dynamic HTML Fields using JQuery Plugin in PHP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="<?php echo base_url();?>'assets/js/repeater.js' file"></script>
    </head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Add Remove Dynamic HTML Fields using JQuery Plugin in PHP</h3>
        <br />
        <div style="width:100%; max-width: 600px; margin:0 auto;">
            <div class="panel panel-default">
                <div class="panel-heading">Add Programming Skill Details</div>
                <div class="panel-body">
                    <span id="success_result"></span>
                    <form method="post" id="repeater_form">
                        <div class="form-group">
                            <label>Enter Programmer Name</label>
                            <input type="text" name="name" id="name" class="form-control" required />
                        </div>
                        <div id="repeater">
                            <div class="repeater-heading" align="right">
                                <button type="button" class="btn btn-primary repeater-add-btn">Add More Skill</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="items" data-group="programming_languages">
                                <div class="item-content">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label>Select Programming Skill</label>
                                                <select data-skip-name="true" data-name="skill[]" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="PHP">PHP</option>
                                                    <option value="Mysql">Mysql</option>
                                                    <option value="JQuery">JQuery</option>
                                                    <option value="Ajax">Ajax</option>
                                                    <option value="AngularJS">AngularJS</option>
                                                    <option value="Codeigniter">Codeigniter</option>
                                                    <option value="Laravel">Laravel</option>
                                                    <option value="Bootstrap">Bootstrap</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3" style="margin-top:24px;" align="center">
                                                <button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group" align="center">
                            <br /><br />
                            <input type="submit" name="insert" class="btn btn-success" value="insert" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function(){
        $('#repeater').createRepeater();

        $('#repeater_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"insert.php",
                method:"POST",
                data:$(this).serialize(),
                success:function(data)
                {
                    $('#repeater_form')[0].reset();
                    $('#repeater').createRepeater();
                    $('#success_result').html(data);
                }
            })
        });

    });
    </script>
    </body>
</html>
