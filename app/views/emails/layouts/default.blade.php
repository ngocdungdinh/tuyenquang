<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable" style="margin: 0;padding: 0;background-color: #FAFAFA;height: 100% !important;width: 100% !important;">
	<tbody><tr>
    	<td align="center" valign="top" style="border-collapse: collapse;">
            <!-- // End Template Preheader \\ -->
        	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border: 1px solid #DDDDDD;background-color: #FFFFFF;">
            	<tbody><tr>
                	<td align="center" valign="top" style="border-collapse: collapse;">
                        <!-- // Begin Template Header \\ -->
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader" style="background-color: #FFFFFF;border-bottom: 0;">
                            <tbody><tr>
                                <td class="headerContent" style="border-collapse: collapse;color: #202020;font-family: Arial;font-size: 34px;font-weight: bold;line-height: 100%;padding: 0;text-align: center;vertical-align: middle; padding: 30px 0px">
                                
                                	<!-- // Begin Module: Standard Header Image \\ -->
                                	<a href="{{ Config::get('app.url') }}"><img src="{{ asset('assets/img/logo-mail.png') }}" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext /></a>
                                	<!-- // End Module: Standard Header Image \\ -->
                                
                                </td>
                            </tr>
                        </tbody></table>
                        <!-- // End Template Header \\ -->
                    </td>
                </tr>
            	<tr>
            		<td style="width: 100%; overflow: hidden; padding: 0px 0px 9px; min-height: 50px; border-bottom: 2px solid #dddddd">
            		</td>
                </tr>
            	<tr>
            		<td style="width: 100%; overflow: hidden; padding: 0px 0px 9px; min-height: 50px; border-bottom: 5px dashed #dddddd">
            		</td>
                </tr>
            	<tr>
            		<td style="width: 100%; overflow: hidden; padding: 0px 0px 9px; min-height: 50px; border-bottom: 2px solid #dddddd">
            		</td>
                </tr>
            	<tr>
                	<td align="center" valign="top" style="border-collapse: collapse;">
                        <!-- // Begin Template Body \\ -->
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                        	<tbody><tr>
                                <td valign="top" class="bodyContent" style="border-collapse: collapse;background-color: #FFFFFF;">
                                    <!-- // Begin Module: Standard Content \\ -->
                                    <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td valign="top" style="border-collapse: collapse;">
                                                <div style="color: #444;font-family: Arial;font-size: 14px;line-height: 150%;text-align: left;">
													@yield('content')
												</div>
											</td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // End Module: Standard Content \\ -->
                                    
                                </td>
                            </tr>
                        </tbody></table>
                        <!-- // End Template Body \\ -->
                    </td>
                </tr>
            	<tr>
                	<td align="center" valign="top" style="border-collapse: collapse;">
                        <!-- // Begin Template Footer \\ -->
                    	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter" style="background-color: #FFFFFF;border-top: 0;">
                        	<tbody><tr>
                            	<td valign="top" class="footerContent" style="border-collapse: collapse;">
                                
                                    <!-- // Begin Module: Standard Footer \\ -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                        <tbody><tr>
                                            <td colspan="2" valign="middle" id="social" style="border-collapse: collapse;background-color: #FAFAFA;border: 0;">
                                                <div style="color: #707070;font-family: Arial;font-size: 12px;line-height: 125%;text-align: center;">
                                                    &nbsp;<a href="{{ Config::get('app.url') }}" style="color: #da500e;font-weight: normal;text-decoration: none;">Trang chủ RoadLine</a> | <a href="https://www.facebook.com/YeuXeDich" style="color: #da500e;font-weight: normal;text-decoration: none;">Facebook</a>&nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="350" style="border-collapse: collapse;">
                                                <div style="color: #707070;font-family: Arial;font-size: 12px;line-height: 125%;text-align: left;">
													<em>Copyright &copy; 2013 - roadline.vn<br />All rights reserved.</em>
													<br />
                                                </div>
                                            </td>
                                            <td valign="top" width="190" id="monkeyRewards" style="border-collapse: collapse;">
                                                <div style="color: #707070;font-family: Arial;font-size: 12px;line-height: 125%;text-align: right;">
													<strong>Liên hệ</strong>
													<br />
													roadline.vn@gmail.com
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // End Module: Standard Footer \\ -->
                                </td>
                            </tr>
                        </tbody></table>
                        <!-- // End Template Footer \\ -->
                    </td>
                </tr>
            </tbody></table>
            <br>
        </td>
    </tr>
</tbody></table>
</body>
</html>
