<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$jambText = <<<'RES'
<!DOCTYPE html>
<html lang="en">
    <!--
    <![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>
	UTME Main Examination Results Notification
</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="description" />
        <meta name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/pages/css/login-soft.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link id="style_components" href="assets/global/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/css/layout.css" rel="stylesheet" type="text/css" />
        <link id="style_color" href="assets/admin/css/themes/darkblue.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/css/custom.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="assets/global/plugins/clockface/css/clockface.css" />
        <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="Account/favicon.ico" />
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="Login">
                <img src="assets/admin/img/logo_big.png" alt="logo" />
            </a>
        </div>
        <div class="col-md-8  col-md-offset-2">
            <div class="account">
                <div id="dvform" class="row" style="margin-left: 5px; margin-right: 5px">
                    <!-- BEGIN LOGIN FORM -->
                    <form method="post" action="./CheckUTMEResults" id="ctl22">
                        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="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" />
                        <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="820CA499" />
                        <input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="jI4Xm/ytc/jFvsEZew1J/lUujbLupNugOv91gwuVJTne0k0HxZKAeU2hbZ5ObE1pHMMfG1Yyi6+sA/RW2eeH8OQWUGz18tCwIGnpyISV0l4sS9JsyA+kthugvN1l9EqK9nrAlU0iOrXMSvrFcOJkfA==" />
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Check My Results</h3>
                                <div class="form-group block">
                                    <span>
                                        <b>Reg Number/e-Mail</b>
                                    </span>
                                    <br />
                                    <input name="txtRegNumber" type="text" value="85982172FF" id="txtRegNumber" class="form-control" placeHolder="Reg Number/e-Mail" />
                                &nbsp;
                                </div>
                                <div class="form-group block">
                                    <a id="lnkSearch" class="btn btn-primary" href="javascript:__doPostBack(&#39;lnkSearch&#39;,&#39;&#39;)">
                    Check My Results 
                                        <i class="fa fa-search m-icon-white"></i>
                                    </a>
                                    <a href="login" style="display: none" class=" btn btn-success pull-right">
                                        <i class="m-icon-swapleft"></i>Back To Login
                                    </a>
                                </div>
                                <br />
                            </div>
                        </div>
                        <div id="dvResults" class="row">
                            <div class="col-md-12" id="dvAll">
                                <div style="overflow: auto; background: #fff">
                                    <table style="width: 100%; font-family: 'Trebuchet MS' Calibri; font-size: small; border: solid 1px #808080">
                                        <tr>
                                            <td style="text-align: center; padding-left: 5px; width: 20%">
                                                <img src="Images/LOGO.png" height="48" />
                                                <h1>JAMB 2018 UTME Results Notification</h1>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">
                                                <center>
                                                    <table  style="width: 90%">
                                                        <tr>
                                                            <td style="text-align: left">Name:
                                                </td>
                                                            <td style="text-align: left">
                                                                <b>
                                                                    <span id="lblName">Adebayo Oluwatumininu Adedayo</span>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left">Reg Number:
                                                </td>
                                                            <td style="text-align: left">
                                                                <b>
                                                                    <span id="lblRegNumber">85982172FF</span>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left;">Date of Birth:
                                                </td>
                                                            <td style="text-align: left;">
                                                                <b>
                                                                    <span id="lblDateofBirth">08 December 1996</span>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left;">Origin:
                                                </td>
                                                            <td style="text-align: left;">
                                                                <b>
                                                                    <span id="lblOrigin">ABEOKUTA-SOUTH in Ogun State.</span>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left">Exam No:
                                                </td>
                                                            <td style="text-align: left">
                                                                <b>
                                                                    <span id="lblexamNo">C47311086</span>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left">Centre Name:
                                                </td>
                                                            <td style="text-align: left">
                                                                <b>
                                                                    <span id="LblCentreName">Pinnacle Royal College, Ilupeju - Idiya Rounder, Abeokuta, Ogun State</span>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">&nbsp;
                                                    
                                                                <div>
                                                                    <table class="Table table-bordered table-striped  table-responsive" cellspacing="0" cellpadding="4" rules="rows" border="1" id="gdvTransHistory" width="100%">
                                                                        <tr align="left" bgcolor="#D9EDF7">
                                                                            <th scope="col">
                                                                                <font color="#333333">Subject</font>
                                                                            </th>
                                                                            <th scope="col">
                                                                                <font color="#333333">Score</font>
                                                                            </th>
                                                                        </tr>
                                                                        <tr class="RowStyle">
                                                                            <td>
                                                                                <font color="#333333">Use of English</font>
                                                                            </td>
                                                                            <td>
                                                                                <font color="#333333">49</font>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="AlternatingRowStyle" bgcolor="#E7F6E7">
                                                                            <td>
                                                                                <font color="#284775">Mathematics</font>
                                                                            </td>
                                                                            <td>
                                                                                <font color="#284775">49</font>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="RowStyle">
                                                                            <td>
                                                                                <font color="#333333">Yoruba</font>
                                                                            </td>
                                                                            <td>
                                                                                <font color="#333333">56</font>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="AlternatingRowStyle" bgcolor="#E7F6E7">
                                                                            <td>
                                                                                <font color="#284775">Commerce</font>
                                                                            </td>
                                                                            <td>
                                                                                <font color="#284775">50</font>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; font-size: large">Total Score:
                                                <b>
                                                    <span id="lblTotalScore">204</span>
                                                </b>
                                                <br />
                                                <img id="imgbar" src="data:image/gif;base64,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" height="37" width="425" />
                                            </td>
                                        </tr>
                                        <tfoot>
                                            <tr>
                                                <td style="text-align: center; font-size: smaller">
                                                    <br />
                                                JAMB UTME&nbsp; 2018
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <br />
                            </div>
                            <div>
                                <br />
                                <button onclick="javascript:printDiv('dvAll');" id="btnprint" class="btn blue">
                                Print Result
                                    <i class="icon-printer m-icon-white"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- END REGISTRATION FORM -->
            
                </div>
            </div>
            <div class="copyright" style="color: #235b2b;">
            2018 &copy; Joint Admissions and Matriculation Board (JAMB)
        </div>
        </div>
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
        <script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="assets/admin/scripts/layout.js" type="text/javascript"></script>
        <script src="assets/admin/scripts/demo.js" type="text/javascript"></script>
        <script src="assets/admin/pages/scripts/login-soft.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/admin/pages/scripts/components-pickers.js"></script>
        <script src="assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/ui-bootbox.min.js" type="text/javascript"></script>
        <script type="text/javascript">
        function PrintElem(elem) {
            // Popup($(elem).html());
            //var d = $('#' + elem).html(); 
            Popup($('#' + elem).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'new div', 'height=400,width=600');
            mywindow.document.write('
            <html>
                <head>
                    <title></title>');
            mywindow.document.write("
                    <link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\" media=\"all\"/>");
            mywindow.document.write('
                </head>
                <body >');
            mywindow.document.write(data);
            mywindow.document.write('</body>
            </html>');

            //mywindow.print();
            //mywindow.close();

            return true;
        }

        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
              "
            <html>
                <head>
                    <title></title>
                </head>
                <body>" +
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
            location.reload();

        }
            </script>
            <script>
        jQuery(document).ready(function () {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Login.init();
            Demo.init();
            ComponentsPickers.init();
            // init background slide images
            $.backstretch([
             //"../assets/admin/pages/media/bg/sidmachofficenight.png",
             "assets/admin/pages/media/bg/3.jpg",
             "assets/admin/pages/media/bg/4.jpg"
            ], {
                fade: 1000,
                duration: 8000
            }
         );
        });
    </script>
            <!-- END JAVASCRIPTS -->

        </body>
        <!-- END BODY -->

    </html>
RES;
