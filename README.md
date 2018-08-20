# MCU Pack Distribution

This Application/Web-Project should create a MCUpdater compatible XML file for Modpacks.


## Usage / Deployment

You can define several environment variables to configure the system properly.
This way you can configure the service without modifying files directly.

You can customize the system in the `config.php` if you don't want to use environment variables.

- `BASE_URL` - Base-URL for downloading mods
- `APP_MASTER_PASSWORD` - Password for the admin UI
- `APP_THEME` - Theme for the HTML preview (XSL Theme)

### Docker 

For this, you need to know how Docker works.
This command will create a docker container
listening on port 8000, several environment variables 
you need to modify and a mounted volumes where
you need to add your modpacks.

```bash
docker run -d -p 8000:8000 \
    --name mcu \
    -e BASE_URL=http://my-host.tld:8000 \
    -e APP_MASTER_PASSWORD=myAdminPassword \
    -v /home/hpeters/modpacks:/app/modpacks \
    sealife/mcu:latest
```

### Apache2

You need direct ssh access to make this work like this - or install it locally and upload it afterwards if using a non-ssh host.

```bash
cd /var/www/html
git clone https://github.com/SeaLife/MCU-PackDistribution.git mcu
cd mcu
./install-twig.sh
```

After this you can access the MCU at ``http://your-host.tld/mcu``

### PHP (should not be used for Production)

```bash
git clone https://github.com/SeaLife/MCU-PackDistribution.git mcu
cd mcu
./install-twig.sh
./run.sh
```

This will open a php session at port 8000. You can access the MCU here:
http://localhost:8000


## Mod-Packs Installation
### Structure

In the application's directory, there is a folder called `modpacks`.

```
root
├── lib/
├── modpacks/           ## the required folder
├── template_admin/
├── template_xml/
├── templates/
├── admin.php
├── index.php
├── config.php
├── app.php
```

In this directory, you create a sub directory for each mod pack.

Example:

```
root
├── lib/
├── modpacks/
    └── MyModPack/
├── template_admin/
├── template_xml/
├── templates/
├── admin.php
├── index.php
├── config.php
└── app.php
```

### Basic Information's

Every mod pack directory contains two sub items...

- `modpack.json`
- `mods/`

The mods directory contains all jar files (the actual mods).
The json file contains some basic information about this pack:

````json
{
	"version": "1",
	"serverAddress": "my-server.tld:25565",
	"autoConnect": false,
	"forgeVersion": "14.23.4.2747",
	"mcVersion": "1.12.2",
	"abstract": false,
	"imports": [ ]
}
````

This item is required, it defines the Minecraft Version, the Forge Version and some basic stuff about the pack itself.
(if this file is missing, the directory is ignored)

After creating all these files, you structure should look like:

```
root
├── lib/
├── modpacks/
│   └── MyModPack/
│       ├── mods/
│       │   ├── my-mod-v1.jar
│       │   ├── industrialcraft.jar
│       │   └── [...].jar
│       └── modpack.json
├── template_admin/
├── template_xml/
├── templates/
├── admin.php
├── index.php
├── config.php
└── app.php
```