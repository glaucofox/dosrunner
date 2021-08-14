# DOS Runner

## Description

Simple application to unzip DOS files to a temporary folder, show the available executable files and run the application using DOSBOX.

## Instructions

### 1. Path to Files

Edit index.php to include the path to your DOS zipped files and temp directory where the files are going to be extracted (lines 5 and 6).
```
$path = "A:/Games/MS-DOS";
$temp = __DIR__ .'./temp/';
```

### 2. Install DOSBox
Install or move DOSBox executable to the `dosbox` folder in this directory.

### 3. Editting Config File

Copy the dosbox configuration file provided in the `conf` folder or 
edit `dosbox-*.conf` located on your `AppData\Local\DOSBox` folder:

```
C:\Users\{username}\AppData\Local\DOSBox
```

#### 3.1 Autoexec

Add to autoexec section the command to mount d drive on the temp folder location (where the files are going to extracted).

```
[autoexec]
# Lines in this section will be run at startup.
# You can put your MOUNT lines here.
mount d c:\msdos\temp\
d:
```

#### 3.2 Makes DOSBox Fullscreen (Optional)

```
fullscreen=true
fulldouble=true
fullresolution=1366x768
windowresolution=1366x768
output=opengl
autolock=true
sensitivity=100
waitonerror=true
priority=higher,normal
mapperfile=mapper-0.74-3.map
usescancodes=true
```

### 4. Run

Run it on XAMPP or using PHP built-in server and access it on your browser `http://localhost:8000`:

```
php -S localhost:8000
```
