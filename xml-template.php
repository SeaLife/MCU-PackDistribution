<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet href="ServerPackv2.xsl" type="text/xsl" ?>
<ServerPack
	version="3.3"
	xmlns="http://www.mcupdater.com"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.mcupdater.com http://files.mcupdater.com/ServerPackv2.xsd">

	<?php foreach ($modpacks as $modpack) { ?>

	<?php $forgeVersion = $modpack["meta"]["forgeVersion"]; ?>
        <?php $mcVersion    = $modpack["meta"]["mcVersion"]; ?>

	<Server
		id="<?php echo $modpack["name"]; ?>"
		name="<?php echo $modpack["name"]; ?>"
		newsUrl="<?php echo "$packUrl/index.php?pack={$modpack["name"]}"; ?>"
		version="<?php echo $modpack["meta"]["mcVersion"]; ?>"
		mainClass="net.minecraft.launchwrapper.Launch"
		revision="<?php echo $modpack["meta"]["version"]; ?>"
		serverAddress="<?php echo $modpack["meta"]["serverAddress"]; ?>"
		abstract="<?php if(@$modpack["meta"]["abstract"]) { echo "true"; } else { echo "false"; } ?>"
		autoConnect="<?php if(@$modpack["meta"]["autoConnect"]) { echo "true"; } else { echo "false"; } ?>">

		<Import url="http://files.mcupdater.com/example/forge.php?mc=<?php echo $mcVersion; ?>&amp;forge=<?php echo $forgeVersion; ?>">forge</Import>

		<?php foreach($modpack["meta"]["imports"] as $import) { ?>

		<Import url="https://mc.r3ktm8.de?import=true&amp;pack=<?php echo $import; ?>"><?php echo $import; ?></Import>

		<?php } ?>

		<Module id="forge-installer-<?php echo $mcVersion; ?>-<?php echo $forgeVersion; ?>" name="Minecraft Forge Installer" side="SERVER">
			<URL priority="0">
				https://files.minecraftforge.net/maven/net/minecraftforge/forge/<?php echo $mcVersion; ?>-<?php echo $forgeVersion; ?>/forge-<?php echo $mcVersion; ?>-<?php echo $forgeVersion; ?>-installer.jar
			</URL>
			<ModPath>forge-installer.jar</ModPath>
 			<ModType order="3" launchArgs="-XX:+UseG1GC -Dsun.rmi.dgc.server.gcInterval=2147483646 -XX:+UnlockExperimentalVMOptions -XX:G1NewSizePercent=20 -XX:G1ReservePercent=20 -XX:MaxGCPauseMillis=50 -XX:G1HeapRegionSize=32M">Library</ModType>
		</Module>

		<?php foreach ($modpack["mods"] as $mod) { ?>

		<Module name="<?php echo $mod["dname"] ?>" id="<?php echo $mod["id"] ?>" depends="" side="<?php echo $mod["side"] ?>">
			<URL priority="0">https://mc.r3ktm8.de/<?php echo rawurlencode($modpack["name"]); ?>/mods/<?php echo $mod["file"] ?></URL>
			<Required><?php if(!$mod["optional"]) { echo "true"; } else { echo "false"; } ?></Required>
			<ModType>Regular</ModType>
			<MD5><?php echo $mod["md5"]; ?></MD5>
                        <?php if(!empty($mod["meta"])) { ?>

			<Meta>
				<authors><?php echo join($mod["meta"]["authorList"]); ?></authors>
				<description><?php echo $mod["meta"]["description"]; ?></description>
				<url><?php echo $mod["meta"]["url"]; ?></url>
				<version><?php echo $mod["meta"]["version"]; ?></version>
			</Meta>
                        <?php } ?>

		</Module>

		<?php } ?>
		
		<Module name="Minecraft Forge" id="forge-<?php echo $forgeVersion; ?>" depends="" side="BOTH">
			<Size>100000</Size>
			<Required>true</Required>
			<ModType order="1">Override</ModType>
		</Module>
	</Server>

	<?php } ?>
</ServerPack>
