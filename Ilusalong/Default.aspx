﻿﻿<%@ Page Title="Home Page" Language="C#" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="Ilusalong._Default" %>

<!DOCTYPE html>
<html>
    <head>
        <title>Salongi Broneeringud</title>
    </head>
    <body>

        <br />
        <div>
            <asp:Xml runat="server" 
                DocumentSource="~/broneeringud.xml"
                TransformSource="~/broneringudlisa.xslt"/>
        </div>
    </body>
</html>