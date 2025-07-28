# BuTils

A simple builder utility PocketMine-MP plugin, designed to be as **easy** as possible to use.

## Features

- [x] Customisable Flying Speed (horizontal & vertical)
- [x] Creative No-Clip
- [x] Toggleable Night Vision
- [x] Toggleable Explosions
- [x] Toggleable Leaves Decay
- [x] Toggleable Liquids Flow
- [x] Toggleable Falling Blocks Gravity
- [x] Toggleable Coral Death
- [x] Minimalistic Overview UI
- [x] Gamemode Commands (Adventure, Creative, Survival, Spectator)

## Commands

| Name        | Description              | Aliases    | Usage                                       | Permission                 |
|-------------|--------------------------|------------|---------------------------------------------|----------------------------|
| butils      | BuTils overview command  | *N/A*      | `/butils`                                   | butils.command.butils      |
| flyspeed    | Update your flying speed | fs, fspeed | `/flyspeed [float:speed]/[string:reset] [float:vertical speed]` | butils.command.flyspeed    |
| nightvision | Toggle night vision      | nv         | `/nightvision`                              | butils.command.nightvision |
| noclip      | Toggle no-clip           | nc         | `/noclip`                                   | butils.command.noclip      |
| gma         | Set player to adventure mode |  | `/gma [player]`                                      | butils.command.gamemode.adventure       |
| gmc         | Set player to creative mode |  | `/gmc [player]`                                      | butils.command.gamemode.creative         |
| gms         | Set player to survival mode |  | `/gms [player]`                                      | butils.command.gamemode.survival          |
| gmsp        | Set player to spectator mode |  | `/gmsp [player]`                                     | butils.command.gamemode.spectator         |
