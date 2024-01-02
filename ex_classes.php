<?php
declare(strict_types=1);

class GameCharacter {
    // プロパティ
    private string $name;
    private int $level;
    private int $attack;
    private int $defense;

    // コンストラクタ
    public function __construct(string $name, int $attack, int $defense){
        $this->name = $name;
        $this->level = 1;
        $this->attack = $attack;
        $this->defense = $defense;
    }

    // メソッド（レベルアップ）
    // レベルアップすると攻撃力と防御力がランダム値上昇する
    public function levelUp(): void {
        $this->level++;
        $this->attackUp();
        $this->defenseUp();
    }

    // メソッド（ステータス表示）
    public function echoStatus(): void {
        echo "{$this->name}はレベル{$this->level}で、攻撃力：{$this->attack}、防御力：{$this->defense}\n";
    }

    private function getRandomValue(): int {
        return random_int(1, 10);
    }

    private function attackUp(): void {
        $up = $this->getRandomValue();
        $this->attack += $up;
        echo "{$this->name}の攻撃力は{$up}上がった\n";
    }

    private function defenseUp(): void {
        $up = $this->getRandomValue();
        $this->defense += $up;
        echo "{$this->name}の防御力は{$up}上がった\n";
    }
}

$taro = new GameCharacter("Taro", 100, 90); //
$jiro = new GameCharacter("Jiro", 80, 110);
$taro->levelUp();
$taro->levelUp();
$taro->echoStatus();
