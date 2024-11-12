<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/">
		<html>
			<head>
				<title>Celestial Touch</title>
				<style>
					.green { background-color: #d4edda; } 
					.yellow { background-color: #fff3cd; } 
					.red { background-color: #f8d7da; } 
				</style>
			</head>
			<body>
				<h2>Celestial Touch</h2>
				<p>
					<b>Värvide selgitus:</b>
				</p>
				<ul>
					<li>
						<span style="background-color: #d4edda;">Roheline</span>: Protseduurid hinnaga alla 30€.
					</li>
					<li>
						<span style="background-color: #fff3cd;">Kollane</span>: Protseduurid hindadega 30€ kuni 50€.
					</li>
					<li>
						<span style="background-color: #f8d7da;">Punane</span>: Protseduurid hinnaga üle 50 €.
					</li>
				</ul>

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
							<xsl:attribute name="class">
								<xsl:choose>
									<xsl:when test="number(translate(hind, '€', '')) &lt; 30">green</xsl:when>
									<xsl:when test="number(translate(hind, '€', '')) &gt;= 30 and number(translate(hind, '€', '')) &lt; 50">yellow</xsl:when>
									<xsl:otherwise>red</xsl:otherwise>
								</xsl:choose>
							</xsl:attribute>
							<td>
								<xsl:value-of select="protseduur" />
							</td>
							<td>
								<xsl:value-of select="kliendinimi" />
							</td>
							<td>
								<xsl:value-of select="telefoninr" />
							</td>
							<td>
								<xsl:value-of select="aeg" />
							</td>
							<td>
								<xsl:value-of select="spetsialist" />
							</td>
							<td>
								<xsl:value-of select="hind" />
							</td>
						</tr>
					</xsl:for-each>

					<tr>
						<td colspan="5">Kokku rekordeid:</td>
						<td>
							<xsl:value-of select="count(salong/broneering/teenus)" />
						</td>
					</tr>

					<tr>
						<td colspan="5">Kogusumma:</td>
						<td>
							<xsl:variable name="totalPrice">
								<xsl:call-template name="calculateSum">
									<xsl:with-param name="nodes" select="salong/broneering/teenus" />
								</xsl:call-template>
							</xsl:variable>
							<xsl:value-of select="$totalPrice" />
						</td>
					</tr>
				</table>
			</body>
		</html>
	</xsl:template>
	<xsl:template name="calculateSum">
		<xsl:param name="nodes" />
		<xsl:param name="sum" select="0" />
		<xsl:choose>
			<xsl:when test="count($nodes) > 0">
				<xsl:variable name="currentPrice" select="translate($nodes[1]/hind, '€', '')" />
				<xsl:call-template name="calculateSum">
					<xsl:with-param name="nodes" select="$nodes[position() > 1]" />
					<xsl:with-param name="sum" select="$sum + number($currentPrice)" />
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$sum" />
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>
