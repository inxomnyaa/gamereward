# gamereward
Execute commands and give items when winning games based on gameapi
## Usage
If you use a plugin that runs via the gameapi virion, for example https://github.com/thebigsmileXD/BedWars or https://github.com/thebigsmileXD/Spleef, a GameWinEvent is called when a team or player wins a game.

This plugin listens for that event and runs commands specified in the config.

When you start the server, gameapi automatically adds entries for the available games on the server into config.yml

You can then simply modify and change the commands.

It can also give the player items by name + meta.
Example:
```
---
Spleef:
  commands:
    "say {display_name} has won a Spleef match"
  items:
    "tnt:0:5"
...
```
## Placeholders
You can see available placeholders here:
https://github.com/thebigsmileXD/gamereward/blob/master/src/xenialdan/gamereward/Loader.php#L81-L139
