<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:x="http://www.mcupdater.com"
                exclude-result-prefixes="x" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation="http://www.mcupdater.com http://files.mcupdater.com/ServerPackv2.xsd">

    <xsl:template match="/">
        <html lang="en-US">
            <head>
                <link href="https://bootswatch.com/4/litera/bootstrap.min.css" rel="stylesheet" type="text/css"/>
                <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->
            </head>
            <body>
                <xsl:for-each select="x:ServerPack/x:Server">
                    <br/>
                    <div class="container-fluid">
                        <div class="card border-primary">
                            <div class="card-header">
                                <b>
                                    <xsl:value-of select="@name"/>
                                </b>
                                Modpack (v<xsl:value-of select="@revision"/>) for Minecraft
                                <xsl:value-of select="@version"/>
                            </div>
                            <div class="card-body">
                                <h4 class="card-text">Mods</h4>
                                <div class="card-text">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Version</th>
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
                                                        <xsl:value-of select="x:Meta/x:version"/>
                                                    </td>
                                                    <td>
                                                        <xsl:value-of select="x:Meta/x:description"/>
                                                        <br/>
                                                        <xsl:if test="string-length(x:Meta/x:authors) &gt; 0">
                                                            Authors:
                                                            <em>
                                                                <xsl:value-of select="x:Meta/x:authors"/>
                                                            </em>
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
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
