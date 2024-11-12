<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
			<head>
				<title>Celestial Touch</title>
			</head>
			<body>
				<h2>Salongi Broneeringud</h2>
				<table border="1">
					<tr>
						<th>Protseduur</th>
						<th>Kliendi Nimi</th>
						<th>Telefon</th>
						<th>Aeg</th>
						<th>Spetsialist</th>
						<th>Hind</th>
					</tr>
					<xsl:for-each select="salong/broneering/teenus">
						<tr>
							<td>
								<xsl:value-of select="protseduur"/>
							</td>
							<td>
								<xsl:value-of select="kliendinimi"/>
							</td>
							<td>
								<xsl:value-of select="telefoninr"/>
							</td>
							<td>
								<xsl:value-of select="aeg"/>
							</td>
							<td>
								<xsl:value-of select="spetsialist"/>
							</td>
							<td>
								<xsl:value-of select="hind"/>
							</td>
						</tr>
					</xsl:for-each>
				</table>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
