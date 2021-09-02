<template>

<main class="d-flex align-items-center">
  <div class="container mt-5">
      <div id="wizard">
        <h3>Step 1 Title</h3>
        <section>
         <h2 class="section-heading">Select Your Order</h2>
         <p>Choose from our selection of order types.</p>
         <div class="purpose-radios-wrapper">
            <div class="purpose-radio">
                <input type="radio" name="purpose" id="solo-division" class="purpose-radio-input" value="SoloDiv" checked>
               <label for="branding" class="purpose-radio-label">
                 <span class="label-icon">
                   <img src="assets/images/icon_branding.svg" alt="solo_division_icon" class="label-icon-default">
                   <img src="assets/images/icon_branding_green.svg" alt="solo_division_icon" class="label-icon-active">
                 </span>
                 <span class="label-text">Solo Division</span>
               </label>
              </div>
              <div class="purpose-radio">
                 <input type="radio" name="purpose" id="duo-division" class="purpose-radio-input" value="DuoDiv">
                <label for="duo-division" class="purpose-radio-label">
                  <span class="label-icon">
                    <img src="assets/images/icon_mobile_design.svg" alt="duo_division_icon" class="label-icon-default">
                    <img src="assets/images/icon_mobile_design_green.svg" alt="duo_division_icon" class="label-icon-active">
                  </span>
                  <span class="label-text">Duo Division</span>
                </label>
               </div>
               <div class="purpose-radio">
                   <input type="radio" name="purpose" id="solo-placements" class="purpose-radio-input" value="SoloPlace">
                  <label for="solo-placements" class="purpose-radio-label">
                    <span class="label-icon">
                      <img src="assets/images/icon_web_design.svg" alt="solo_placement_icon" class="label-icon-default">
                      <img src="assets/images/icon_web_design_green.svg" alt="solo_placement_icon" class="label-icon-active">
                    </span>
                    <span class="label-text">Solo Placements</span>
                  </label>
                 </div>
                 <div class="purpose-radio">
                    <input type="radio" name="purpose" id="duo-placements" class="purpose-radio-input" value="DuoPlace">
                   <label for="duo-placements" class="purpose-radio-label">
                     <span class="label-icon">
                       <img src="assets/images/icon_mobile_design.svg" alt="duo_placement_icon" class="label-icon-default">
                       <img src="assets/images/icon_mobile_design_green.svg" alt="duo_placement_icon" class="label-icon-active">
                     </span>
                     <span class="label-text">Duo Placements</span>
                   </label>
                  </div>
                  <div class="purpose-radio">
                     <input type="radio" name="purpose" id="solo-net-wins" class="purpose-radio-input" value="SoloNet">
                    <label for="solo-net-wins" class="purpose-radio-label">
                      <span class="label-icon">
                        <img src="assets/images/icon_mobile_design.svg" alt="solo_net-wins_icon" class="label-icon-default">
                        <img src="assets/images/icon_mobile_design_green.svg" alt="solo_net-wins_icon" class="label-icon-active">
                      </span>
                      <span class="label-text">Solo Net Wins</span>
                    </label>
                   </div>
                   <div class="purpose-radio">
                      <input type="radio" name="purpose" id="duo-net-wins" class="purpose-radio-input" value="DuoNet">
                     <label for="duo-net-wins" class="purpose-radio-label">
                       <span class="label-icon">
                         <img src="assets/images/icon_mobile_design.svg" alt="duo_net-wins_icon" class="label-icon-default">
                         <img src="assets/images/icon_mobile_design_green.svg" alt="duo_net-wins_icon" class="label-icon-active">
                       </span>
                       <span class="label-text">Duo Net Wins</span>
                     </label>
                    </div>
                    <div class="purpose-radio">
                       <input type="radio" name="purpose" id="tft-boosting" class="purpose-radio-input" value="TFTBoost">
                      <label for="tft-boosting" class="purpose-radio-label">
                        <span class="label-icon">
                          <img src="assets/images/icon_mobile_design.svg" alt="branding" class="label-icon-default">
                          <img src="assets/images/icon_mobile_design_green.svg" alt="branding" class="label-icon-active">
                        </span>
                        <span class="label-text">TFT Boosting</span>
                      </label>
                     </div>
                     <div class="purpose-radio">
                        <input type="radio" name="purpose" id="coaching" class="purpose-radio-input" value="Coaching">
                       <label for="coaching" class="purpose-radio-label">
                         <span class="label-icon">
                           <img src="assets/images/icon_mobile_design.svg" alt="coaching_icon" class="label-icon-default">
                           <img src="assets/images/icon_mobile_design_green.svg" alt="coaching_icon" class="label-icon-active">
                         </span>
                         <span class="label-text">Coaching</span>
                       </label>
                      </div>
         </div>
        </section>
        <h3>Step 2 Title</h3>
        <section>
          <h5 class="bd-wizard-step-title">Step 2</h5>
          <h2 class="section-heading">Enter your Account Details</h2>
          <div class="form-group">
            <label for="firstName" class="sr-only">First Name</label>
            <input type="text" name="firstName" id="firstName" class="form-control" placeholder="First Name">
          </div>
          <div class="form-group">
            <label for="lastName" class="sr-only">Last Name</label>
            <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name">
          </div>
          <div class="form-group">
            <label for="phoneNumber" class="sr-only">Phone Number</label>
            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="Phone Number">
          </div>
          <div class="form-group">
            <label for="emailAddress" class="sr-only">Email Address</label>
            <input type="email" name="emailAddress" id="emailAddress" class="form-control" placeholder="Email Address">
          </div>
        </section>
        <h3>Step 3 Title</h3>
        <section>
            <h5 class="bd-wizard-step-title">Step 3</h5>
            <h2 class="section-heading mb-5">Review your Details and Submit</h2>
            <h6 class="font-weight-bold">Select business type</h6>
            <p class="mb-4" id="business-type">Branding</p>
            <h6 class="font-weight-bold">Enter your Account Details</h6>
            <p class="mb-4"><span id="enteredFirstName">Cha</span> <span id="enteredLastName">Ji-Hun C</span> <br>
                Phone: <span id="enteredPhoneNumber">+230-582-6609</span> <br>
                Email: <span id="enteredEmailAddress">willms_abby@gmail.com</span></p>

        </section>
      </div>
  </div>
</main>
</template>

<style src="./bd-wizard.css" scoped>
</style>


<script>

    export default {
        mounted() {
            //console.log('Component mounted.')

        }
    }
</script>
