<div class="modal" id="privacy_mdl"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Privacy Policy</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <!-- Not 100% sure why this is here, should move soon -->
                <style type="text/css">
                    .und {
                        border: 0;
                        outline: 0;
                        background: transparent;
                        border-bottom: 1px solid black;
                    }

                    .eql {
                        width: 66%;
                    }
                </style>
                <form onsubmit="get_image_data(event)" method="POST">
                <p> By continuing to use the site you agree to the Oxbridge Careers Hub <a href="../../Agreement_for_the_Sharing_of_Data.pdf">Agreement for the Sharing of Data</a>, <a href="../../TermsofUse.pdf">Terms of Use</a> and <a href="../../Privacypolicy.pdf">Privacy Policy</a>. Please read these before accessing the site, particularly the Agreement for the Sharing of Data.</p>
                    <center>
                        <input type="text" class="form-control text-center eql" name="company_name" placeholder="Company name" required>
                        <br />
                        <input type="text" class="form-control text-center eql" name="signer_name" placeholder="Signer name" required>
                        <br />
                    </center>
                    <label>Sign Here (use mouse)</label>
                    <center>
                        <div id="captureSignature" class="kbw-signature"></div>
                    </center>
                    <br />
                    <button class="btn btn-info" type="button" id="clear2Button">Clear Sign Area</button>
                    <br />
                    <br />
                    <textarea id="signatureJSON" name="signature" rows="5" cols="50" readonly="" class="ui-state-active" style="display: none;"></textarea>
                    <button type="submit" class="btn btn-primary btn-block">Accept</button>
                </form>
            </div>
            <!-- Not sure if this is truly necessary? -->
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Load in signature capture scripts -->
<script src="scripts/modal.js"></script>