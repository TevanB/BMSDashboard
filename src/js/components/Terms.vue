<template>
    <div class="container" v-if="$gate.isWorkerOrAdmin()">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">BMS Boosting Team Rules</div>

                    <div class="card-body">
                    The following are rules that employees from BMS Boosting need to follow. This includes boosters, coaches and customer support. You accept these rules whenever you claim a boosting or coaching order.<br>
                    <br>
                    1. When boosting on a client’s account, the use of third party programs is completely forbidden.<br>
                    <br>
                    2. When boosting on a client’s account, you are not allowed to use/spend the client’s Blue Essence, Orange Essence, or Riot Points, without contacting BMS Boosting , and asking for permission.<br>
                    <br>
                    3. When interacting with a client during duo-boosts or coaching services, you are expected to treat them and everyone else in the game (during duo-boosts) with respect.<br>
                    <br>
                    4. Getting a clients account account banned or chat restricted during a Solo-Boost is absolutely not acceptable and will result in consequences.<br>
                    <br>
                    5. There are minimal expected win-rates for Solo-Boosts, which you have to achieve when accepting a boost. These are listed below. You need to achieve these winrates in your first 20 games of the boost.<br>
                    <br>
                    Iron 4 – Gold 4 minimal winrate: 90% <br>
                    Gold 3 – Platinum 4 minimal winrate: 85% <br>
                    Platinum 3 – Diamond 4 minimal winrate: 75% <br>
                    Diamond 3 – Masters minimal winrate: 65% <br>
                    <br>
                    6. When using a clients account for a solo-Boost, you are not allowed to contact people on the clients friend list, or reveal any information about performing a boost. <br>
                    <br>
                    7. Trolling, intentionally going afk or intentionally feeding during any kind of boost is forbidden. <br>
                    <br>
                    8. Contacting a client outside of the Order Dashboard chat is forbidden unless approved by BMS Boosting management, if a client tries contacting you outside this Dashboard please report it to BMS Boosting Management. <br>
                    <br>
                    Not following one of the seven points may result in a reassign, and a change of payout as BMS Boosting believes to be fair (listed below). <br>
                    <br>
                    Using Third Party Cheats or Scripts On Orders - $200 USD <br>
                    Deranking either Rank, Division or LP and Leaving Order or BMS - $500 USD <br>
                    Toxicity in any form - $30 to 100 USD <br>
                    Not Completing an Order - $80 USD <br>
                    Customer Sniping or Privately Contacting Customer Without Informing Owner - $1000 USD <br>
                    Not reporting a violation of BMS Boosting's Terms of Service - $50 USD <br>
                    Not contacting the owner when a problem occurs - $30 USD <br>
                    Any other fines can be decided by discretion of managment up to $1000 USD based on severity. <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="$gate.isClient()">
      <not-found></not-found>

    </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>
