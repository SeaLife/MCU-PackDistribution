<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:x="http://www.mcupdater.com"
                exclude-result-prefixes="x" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation="http://www.mcupdater.com http://files.mcupdater.com/ServerPackv2.xsd">

    <xsl:template match="/">
        <html lang="en-US">
            <head>
                <link href="https://bootswatch.com/4/lumen/bootstrap.min.css" rel="stylesheet" type="text/css"/>
                <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->
            </head>
            <body>
                <xsl:for-each select="x:ServerPack/x:Server">
                    <br/>
                    <div class="container-fluid">
                        <div class="card">
                            <xsl:attribute name="class">
                                <xsl:choose>
                                    <xsl:when test="@abstract = 'true'">card border-danger</xsl:when>
                                    <xsl:otherwise>card border-success</xsl:otherwise>
                                </xsl:choose>
                            </xsl:attribute>

                            <div class="card-header">
                                <b>
                                    <xsl:value-of select="@name"/>
                                </b>
                                Modpack (v<xsl:value-of select="@revision"/>) for Minecraft
                                <xsl:value-of select="@version"/>

                                <xsl:choose>
                                    <xsl:when test="@abstract = 'true'">
                                        (<i>This Pack cannot be played directly!</i>)
                                    </xsl:when>
                                </xsl:choose>
                            </div>
                            <div class="card-body">
                                <h4 class="card-text">Mods</h4>
                                <div class="card-text">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Name</th>
                                                <th width="20%">Version</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <xsl:for-each select="x:Module">
                                                <tr>
                                                    <td>
                                                        <xsl:choose>
                                                            <xsl:when test="string-length(x:Meta/x:url) &gt; 0">
                                                                <a href="{x:Meta/x:url}">
                                                                    <xsl:value-of select="@name"/>
                                                                </a>
                                                            </xsl:when>
                                                            <xsl:otherwise>
                                                                <xsl:value-of select="@name"/>
                                                            </xsl:otherwise>
                                                        </xsl:choose>
                                                    </td>
                                                    <td>
                                                        <xsl:choose>
                                                            <xsl:when test="string-length(x:Meta/x:version) &gt; 0">
                                                                <b>
                                                                    <xsl:value-of select="x:Meta/x:version"/>
                                                                </b>
                                                            </xsl:when>
                                                            <xsl:otherwise>
                                                                <i>not available</i>
                                                            </xsl:otherwise>
                                                        </xsl:choose>
                                                    </td>
                                                    <td>
                                                        <xsl:value-of select="x:Meta/x:description"/>
                                                        <br/>
                                                        <xsl:if test="string-length(x:Meta/x:authors) &gt; 0">
                                                            Made by:
                                                            <strong>
                                                                <xsl:value-of select="x:Meta/x:authors"/>
                                                            </strong>
                                                        </xsl:if>
                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </tbody>
                                    </table>
                                </div>


                                <xsl:if test="count(x:Import)&gt;0">
                                    <h4 class="card-text">Imports</h4>

                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>Id</th>
                                        </tr>
                                        <xsl:for-each select="x:Import">
                                            <tr>
                                                <td class="modname">
                                                    <xsl:choose>
                                                        <xsl:when test="string-length(@url) &gt; 0">
                                                            <a href="{@url}">
                                                                <xsl:value-of select="."/>
                                                            </a>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <xsl:value-of select="."/>
                                                        </xsl:otherwise>
                                                    </xsl:choose>
                                                </td>
                                            </tr>
                                        </xsl:for-each>
                                    </table>
                                </xsl:if>
                            </div>
                        </div>
                    </div>
                </xsl:for-each>
                <br/>
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <b>Administration</b>
                        </div>
                        <div class="card-body">
                            Go to the ModPack <a href="index.php/admin">Administration</a> overlay to modify the modpack.
                        </div>
                    </div>
                </div>
                <br/>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
