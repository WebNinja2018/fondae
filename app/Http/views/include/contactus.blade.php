 <div class="footer-form wow fadeIn" data-wow-duration="2s" data-wow-delay="0.4s">
                        <div class="top-head">
                            <h1>Contact Us</h1>
                        </div>
                        <div class="form-form">
                            <div class="expMessage"></div>
                            <form  action="{{ url('/') }}/contactsubmit" method="post">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" required>    
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                <label for="message">Message:</label>
                                <textarea name="message" id="message" class="form-control" rows="4"  required></textarea>
                                <div class="form-btn">
                                    <button type="submit" class="btn btn-default hvr-shutter-out-horizontal">Submit</button>                                
                                </div>
                                <input type="hidden" name="action" value="submitform" >
                            </form>
                        </div>
                    </div>