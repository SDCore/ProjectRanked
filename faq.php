<?php
    $title = "Home";
    require_once("./include/nav.php");
?>

<div class="header">
    <div class="top">Frequently Asked Questions</div>
</div>

<div class="container">
    <div class="faq">
        <div class="question">
            I don't see myself on the leaderboard. Is there some way I could get myself added?
        </div>
        <div class="answer">
            Currently, there is no way on the website to add yourself to the leaderboard, but that is being worked on. If you would like to be added manually, hit me up on Discord (SDCore#0001) or Twitter (@SDCore_) with your Apex username and the platform that you play on, and I'll add you.
        </div>
    </div>
    <div class="faq">
        <div class="question">
            Why do Preds and Masters have position numbers next to them, but other ranks don't?
        </div>
        <div class="answer">
            It's only possible to get rankings for players in Apex Predator and Master. While it would be possible to get a ranking based on the data in the database, it's easier to just rank Apex Predators and Masters, as that's how Respawn does it, and Preds/Masters are essentially the same tier, the only difference being Preds are the top 750 of Masters.
        </div>
    </div>
    <div class="faq">
        <div class="question">
            Are mobile leaderboards coming?
        </div>
        <div class="answer">
            The mobile version of Apex is developed by Tencent, not Respawn. More or less, it runs on a different version and the backend is different compared to the main version, so the ways that we use to get info for the main version of Apex do not work for mobile. There's a slim chance in the future that we might have stats on mobile users, but it's not in the cards right now.
        </div>
    </div>
    <div class="faq">
        <div class="question">
            Why does the leaderboard not show any rank under Platinum?
        </div>
        <div class="answer">
            Most of the playerbase is going to be Plat+, so I don't see too much value in showing anything below that rank. There are people added to the database that are Gold or below, they just don't show up. This might be changed in the future, but for now, it's mainly a leaderboard for people looking to grind ranked and see where they place against other similar players.
        </div>
    </div>
    <div class="faq">
        <div class="question">
            Why do some people not have a ranked history (ie. show "Unranked"), while others do?
        </div>
        <div class="answer">
            I (currently) manually add each person to the database, so in earlier ranked seasons, there were less people than there are in later/current rank seasons. So the fact that they show as "Unranked" could be because they weren't in the database at that time, or they simply didn't play ranked for that season.
        </div>
    </div>
    <div class="faq">
        <div class="question">
            Why do some people have "Legend#1234" as their name?
        </div>
        <div class="answer">
            Some people don't have publicly displayed names, have removed their name entirely, or have names that can't be processed (ie. are in another language). If this happens, it'll show their currently active legend followed by their current level.
        </div>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>
