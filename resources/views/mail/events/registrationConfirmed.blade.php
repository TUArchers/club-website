<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Your Reservation is Confirmed</title>

    <!--
        This email is an experimental proof-of-concept based on the
        idea that the most common design patterns seen in email can
        be placed in modular blocks and moved around to create
        different designs.

        The same principle is used to build the email templates in
        MailChimp's Drag-and-Drop email editor.

        This email is optimized for mobile email clients, and even
        works relatively well in the Android Gmail App, which does
        not support Media Queries, but does have limited mobile-
        friendly functionality.

        While this coding method is very flexible, it can be more
        brittle than traditionally-coded emails, particularly in
        Microsoft Outlook 2007-2010. Outlook-specific conditional
        CSS is included to counteract the inconsistencies that
        crop up.

        For more information on HTML email design and development,
        visit http://templates.mailchimp.com
    -->

    <style type="text/css">
        /*////// RESET STYLES //////*/
        body, #bodyTable, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;}
        table{border-collapse:collapse;}
        img, a img{border:0; outline:none; text-decoration:none;}
        h1, h2, h3, h4, h5, h6{margin:0; padding:0;}
        p{margin: 1em 0;}

        /*////// CLIENT-SPECIFIC STYLES //////*/
        .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
        #outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
        img{-ms-interpolation-mode: bicubic;} /* Force IE to smoothly render resized images. */
        body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */

        /*////// FRAMEWORK STYLES //////*/
        .flexibleContainerCell{padding-top:20px; padding-Right:20px; padding-Left:20px;}
        .flexibleImage{height:auto;}
        .bottomShim{padding-bottom:20px;}
        .imageContent, .imageContentLast{padding-bottom:20px;}
        .nestedContainerCell{padding-top:20px; padding-Right:20px; padding-Left:20px;}

        /*////// GENERAL STYLES //////*/
        body, #bodyTable{background-color:#F5F5F5;}
        #bodyCell{padding-top:40px; padding-bottom:40px;}
        #emailBody{background-color:#FFFFFF; border:1px solid #DDDDDD; border-collapse:separate; border-radius:4px;}
        h1, h2, h3, h4, h5, h6{color:#202020; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left;}
        .textContent, .textContentLast{color:#404040; font-family:Helvetica; font-size:16px; line-height:125%; text-align:Left; padding-bottom:20px;}
        .textContent a, .textContentLast a{color:#2C9AB7; text-decoration:underline;}
        .nestedContainer{background-color:#E5E5E5; border:1px solid #CCCCCC;}
        .emailButton{background-color:#2C9AB7; border-collapse:separate; border-radius:4px;}
        .buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
        .buttonContent a{color:#FFFFFF; display:block; text-decoration:none;}
        .emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
        .emailCalendarMonth{background-color:#2C9AB7; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
        .emailCalendarDay{color:#2C9AB7; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}

        /*////// MOBILE STYLES //////*/
        @media only screen and (max-width: 480px){
            /*////// CLIENT-SPECIFIC STYLES //////*/
            body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */

            /*////// FRAMEWORK STYLES //////*/
            /*
                CSS selectors are written in attribute
                selector format to prevent Yahoo Mail
                from rendering media query styles on
                desktop.
            */
            table[id="emailBody"], table[class="flexibleContainer"]{width:100% !important;}

            /*
                The following style rule makes any
                image classed with 'flexibleImage'
                fluid when the query activates.
                Make sure you add an inline max-width
                to those images to prevent them
                from blowing out.
            */
            img[class="flexibleImage"]{height:auto !important; width:100% !important;}

            /*
                Make buttons in the email span the
                full width of their container, allowing
                for left- or right-handed ease of use.
            */
            table[class="emailButton"]{width:100% !important;}
            td[class="buttonContent"]{padding:0 !important;}
            td[class="buttonContent"] a{padding:15px !important;}

            td[class="textContentLast"], td[class="imageContentLast"]{padding-top:20px !important;}

            /*////// GENERAL STYLES //////*/
            td[id="bodyCell"]{padding-top:10px !important; padding-Right:10px !important; padding-Left:10px !important;}
        }
    </style>
    <!--
        Outlook Conditional CSS

        These two style blocks target Outlook 2007 & 2010 specifically, forcing
        columns into a single vertical stack as on mobile clients. This is
        primarily done to avoid the 'page break bug' and is optional.

        More information here:
        http://templates.mailchimp.com/development/css/outlook-conditional-css
    -->
    <!--[if mso 12]>
    <style type="text/css">
        .flexibleContainer{display:block !important; width:100% !important;}
    </style>
    <![endif]-->
    <!--[if mso 14]>
    <style type="text/css">
        .flexibleContainer{display:block !important; width:100% !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F5F5F5;height: 100% !important;width: 100% !important;">
<center>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #F5F5F5;height: 100% !important;width: 100% !important;">
        <tr>
            <td align="center" valign="top" id="bodyCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;padding-top: 40px;padding-bottom: 40px;height: 100% !important;width: 100% !important;">
                <!-- EMAIL CONTAINER // -->
                <!--
                    The table "emailBody" is the email's container.
                    Its width can be set to 100% for a color band
                    that spans the width of the page.
                -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="emailBody" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border: 1px solid #DDDDDD;border-radius: 4px;">


                    <!-- MODULE ROW // -->
                    <tr>
                        <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <!-- CENTERING TABLE // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <tr>
                                    <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <tr>
                                                <td valign="top" width="600" class="flexibleContainerCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-top: 20px;padding-right: 20px;padding-left: 20px;">


                                                    <!-- CONTENT TABLE // -->
                                                    <table align="Left" border="0" cellpadding="0" cellspacing="0" width="200" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                        <tr>
                                                            <td align="Left" valign="top" class="imageContent" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-bottom: 20px;">
                                                                <img src="{{ asset('img/tua-club-logo-small.png')  }}" width="175" class="flexibleImage" style="max-width: 175px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;height: auto;">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // CONTENT TABLE -->


                                                    <!-- CONTENT TABLE // -->
                                                    <table align="Right" border="0" cellpadding="0" cellspacing="0" width="340" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                        <tr>
                                                            <td valign="top" class="textContent" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #404040;font-family: Helvetica;font-size: 16px;line-height: 125%;text-align: Left;padding-bottom: 20px;">
                                                                <h3 style="margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 20px;line-height: 125%;text-align: Left;">Hi {{ $first_name }}</h3>
                                                                <br>
                                                                We're pleased to say that your free archery taster session with Teesside University Archers has been confirmed.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // CONTENT TABLE -->


                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>
                    <!-- // MODULE ROW -->

                    <!-- MODULE ROW // -->
                    <tr>
                        <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <!-- CENTERING TABLE // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <tr>
                                    <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <tr>
                                                <td align="center" valign="top" width="600" class="flexibleContainerCell bottomShim" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-top: 20px;padding-right: 20px;padding-left: 20px;padding-bottom: 20px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nestedContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #E5E5E5;border: 1px solid #CCCCCC;">
                                                        <tr>
                                                            <td valign="top" class="nestedContainerCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-top: 20px;padding-right: 20px;padding-left: 20px;">


                                                                <!-- CONTENT TABLE // -->
                                                                <table align="Right" border="0" cellpadding="0" cellspacing="0" width="160" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <tr>
                                                                        <td align="center" valign="top" class="bottomShim" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-bottom: 20px;">
                                                                            <table border="0" cellpadding="0" cellspacing="0" width="160" class="emailCalendar" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border: 1px solid #CCCCCC;">
                                                                                <tr>
                                                                                    <td align="center" valign="top" style="padding: 5px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                            <tr>
                                                                                                <td align="center" valign="top" class="emailCalendarMonth" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #2C9AB7;color: #FFFFFF;font-family: Helvetica, Arial, sans-serif;font-size: 16px;font-weight: bold;padding-top: 10px;padding-bottom: 10px;text-align: center;">
                                                                                                    {{ $start_month }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="center" valign="top" class="emailCalendarDay" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #2C9AB7;font-family: Helvetica, Arial, sans-serif;font-size: 60px;font-weight: bold;line-height: 100%;padding-top: 20px;padding-bottom: 20px;text-align: center;">
                                                                                                    {{ $start_day }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <!-- // CONTENT TABLE -->


                                                                <!-- CONTENT TABLE // -->
                                                                <table align="Left" border="0" cellpadding="0" cellspacing="0" width="320" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <tr>
                                                                        <td valign="top" class="textContent" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #404040;font-family: Helvetica;font-size: 16px;line-height: 125%;text-align: Left;padding-bottom: 20px;">
                                                                            <h3 style="margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 20px;line-height: 125%;text-align: Left;">Your Taster Session</h3>
                                                                            <br>
                                                                            <b>Arrival Time: </b>{{ $arrival_time }}
                                                                            <br>
                                                                            <b>Start Time: </b>{{ $start_time }}
                                                                            <br>
                                                                            <b>Location: </b>{{ $location }}
                                                                            <br>
                                                                            <b>Reference: </b>{{ $reference }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <!-- // CONTENT TABLE -->


                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>
                    <!-- // MODULE ROW -->

                    <!-- MODULE ROW // -->
                    <!--
                        To move or duplicate any of the design patterns
                        in this email, simply move or copy the entire
                        MODULE ROW section for each content block.
                    -->
                    <tr>
                        <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <!-- CENTERING TABLE // -->
                            <!--
                                The centering table keeps the content
                                tables centered in the emailBody table,
                                in case its width is set to 100%.
                            -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <tr>
                                    <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <!--
                                            The flexible container has a set width
                                            that gets overridden by the media query.
                                            Most content tables within can then be
                                            given 100% widths.
                                        -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <tr>
                                                <td align="center" valign="top" width="600" class="flexibleContainerCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-top: 20px;padding-right: 20px;padding-left: 20px;">


                                                    <!-- CONTENT TABLE // -->
                                                    <!--
                                                        The content table is the first element
                                                        that's entirely separate from the structural
                                                        framework of the email.
                                                    -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                        <tr>
                                                            <td valign="top" class="textContent" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #404040;font-family: Helvetica;font-size: 16px;line-height: 125%;text-align: Left;padding-bottom: 20px;">
                                                                <h3 style="margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 20px;line-height: 125%;text-align: Left;">Important Stuff</h3>
                                                                <br>
                                                                You'll need to bring the following things with you:
                                                                <ul>
                                                                    <li style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Comfortable clothing that's not too loose</li>
                                                                    <li style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Shoes that cover your toes</li>
                                                                    <li style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">A copy of this email or something to show it on (save the trees!)</li>
                                                                </ul>
                                                                <br>
                                                                <h3 style="margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 20px;line-height: 125%;text-align: Left;">More Important Stuff</h3>
                                                                <br>
                                                                {!! str_replace("\n", "<br><br>", trim(e($details), "\n")) !!}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // CONTENT TABLE -->


                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>
                    <!-- // MODULE ROW -->

                    <!-- MODULE ROW // -->
                    <!--
                        To move or duplicate any of the design patterns
                        in this email, simply move or copy the entire
                        MODULE ROW section for each content block.
                    -->
                    <tr>
                        <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <!-- CENTERING TABLE // -->
                            <!--
                                The centering table keeps the content
                                tables centered in the emailBody table,
                                in case its width is set to 100%.
                            -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <tr>
                                    <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <!--
                                            The flexible container has a set width
                                            that gets overridden by the media query.
                                            Most content tables within can then be
                                            given 100% widths.
                                        -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <tr>
                                                <td align="center" valign="top" width="600" class="flexibleContainerCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;padding-top: 20px;padding-right: 20px;padding-left: 20px;">


                                                    <!-- CONTENT TABLE // -->
                                                    <!--
                                                        The content table is the first element
                                                        that's entirely separate from the structural
                                                        framework of the email.
                                                    -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                        <tr>
                                                            <td valign="top" class="textContent" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #404040;font-family: Helvetica;font-size: 16px;line-height: 125%;text-align: Left;padding-bottom: 20px;">
                                                                <h3 style="margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 20px;line-height: 125%;text-align: Left;">Can't make your session?</h3>
                                                                <br>
                                                                Please let us know as soon as possible so we can offer your spot to someone else and find you a new spot.
                                                                Just send an email to {{'committee@tuarchers.org.uk'}} and we'll take it from there.
                                                                <br>
                                                                <br>
                                                                <i>P.S. Do not reply directly to this email - your reply will go nowhere!</i>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // CONTENT TABLE -->


                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>
                    <!-- // MODULE ROW -->
                </table>
                <!-- // EMAIL CONTAINER -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>