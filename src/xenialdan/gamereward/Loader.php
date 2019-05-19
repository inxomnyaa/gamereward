<?php

namespace xenialdan\gamereward;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use xenialdan\gameapi\Game;

class Loader extends PluginBase
{
    /** @var Loader */
    private static $instance = null;

    /**
     * Returns an instance of the plugin
     * @return Loader
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    public function onLoad()
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->reloadConfig();
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }

    public function addGame(Game $game)
    {
        if ($this->getConfig()->exists($game->getName())) return;
        $this->getConfig()->set($game->getName(), ["commands" => [], "items" => []]);
        $this->getConfig()->save();
    }

    public function removeGame(Game $game)
    {
        if ($this->getConfig()->exists($game->getName()))
            $this->getConfig()->remove($game->getName());
    }

    public function executeRewards(Game $game, $winningPlayers)
    {
        $config = $this->getConfig()->get($game->getName(), ["commands" => [], "items" => []]);
        foreach ($winningPlayers as $player) {
            /** @var Player $player */
            self::runCommands($player, $config["commands"]);
            if ($player->isOnline() && !empty($config["items"])) {
                $player->getInventory()->addItem(...ItemFactory::fromString(implode(",", $config["items"]), true));
            }
        }
    }

    public static function runCommands(Player $player, $commands)
    {
        foreach ($commands as $command) {
            Server::getInstance()->getCommandMap()->dispatch(new ConsoleCommandSender(), self::formatText($player, $command));
            var_dump(self::formatText($player, $command));
        }
    }

    /**
     * Formats the string
     *
     * @param Player $player
     * @param string $text
     * @return string
     */
    public static function formatText(Player $player, string $text)
    {
        $text = str_replace("{display_name}", $player->getDisplayName(), $text);
        $text = str_replace("{name}", $player->getName(), $text);
        $text = str_replace("{x}", $player->getFloorX(), $text);
        $text = str_replace("{y}", $player->getFloorY(), $text);
        $text = str_replace("{z}", $player->getFloorZ(), $text);
        $text = str_replace("{world}", (($levelname = $player->getLevel()->getName()) === false ? "" : $levelname), $text);
        $text = str_replace("{level_players}", count($player->getLevel()->getPlayers()), $text);
        $text = str_replace("{server_players}", count($player->getServer()->getOnlinePlayers()), $text);
        $text = str_replace("{server_max_players}", $player->getServer()->getMaxPlayers(), $text);
        $text = str_replace("{hour}", date('H'), $text);
        $text = str_replace("{minute}", date('i'), $text);
        $text = str_replace("{second}", date('s'), $text);
        // preg_match_all ("/(\{.*?\})/ig", $text, $brackets);

        $text = str_replace("{BLACK}", "&0", $text);
        $text = str_replace("{DARK_BLUE}", "&1", $text);
        $text = str_replace("{DARK_GREEN}", "&2", $text);
        $text = str_replace("{DARK_AQUA}", "&3", $text);
        $text = str_replace("{DARK_RED}", "&4", $text);
        $text = str_replace("{DARK_PURPLE}", "&5", $text);
        $text = str_replace("{GOLD}", "&6", $text);
        $text = str_replace("{GRAY}", "&7", $text);
        $text = str_replace("{DARK_GRAY}", "&8", $text);
        $text = str_replace("{BLUE}", "&9", $text);
        $text = str_replace("{GREEN}", "&a", $text);
        $text = str_replace("{AQUA}", "&b", $text);
        $text = str_replace("{RED}", "&c", $text);
        $text = str_replace("{LIGHT_PURPLE}", "&d", $text);
        $text = str_replace("{YELLOW}", "&e", $text);
        $text = str_replace("{WHITE}", "&f", $text);
        $text = str_replace("{OBFUSCATED}", "&k", $text);
        $text = str_replace("{BOLD}", "&l", $text);
        $text = str_replace("{STRIKETHROUGH}", "&m", $text);
        $text = str_replace("{UNDERLINE}", "&n", $text);
        $text = str_replace("{ITALIC}", "&o", $text);
        $text = str_replace("{RESET}", "&r", $text);

        $text = str_replace("&0", TextFormat::BLACK, $text);
        $text = str_replace("&1", TextFormat::DARK_BLUE, $text);
        $text = str_replace("&2", TextFormat::DARK_GREEN, $text);
        $text = str_replace("&3", TextFormat::DARK_AQUA, $text);
        $text = str_replace("&4", TextFormat::DARK_RED, $text);
        $text = str_replace("&5", TextFormat::DARK_PURPLE, $text);
        $text = str_replace("&6", TextFormat::GOLD, $text);
        $text = str_replace("&7", TextFormat::GRAY, $text);
        $text = str_replace("&8", TextFormat::DARK_GRAY, $text);
        $text = str_replace("&9", TextFormat::BLUE, $text);
        $text = str_replace("&a", TextFormat::GREEN, $text);
        $text = str_replace("&b", TextFormat::AQUA, $text);
        $text = str_replace("&c", TextFormat::RED, $text);
        $text = str_replace("&d", TextFormat::LIGHT_PURPLE, $text);
        $text = str_replace("&e", TextFormat::YELLOW, $text);
        $text = str_replace("&f", TextFormat::WHITE, $text);
        $text = str_replace("&k", TextFormat::OBFUSCATED, $text);
        $text = str_replace("&l", TextFormat::BOLD, $text);
        $text = str_replace("&m", TextFormat::STRIKETHROUGH, $text);
        $text = str_replace("&n", TextFormat::UNDERLINE, $text);
        $text = str_replace("&o", TextFormat::ITALIC, $text);
        $text = str_replace("&r", TextFormat::RESET, $text);

        return $text;
    }
}