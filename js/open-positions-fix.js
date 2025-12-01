jQuery(document).ready(function($) {
    // Handle email buttons with browser-based options
    $('.mailto-button').on('click', function(e) {
        e.preventDefault();
        
        var email = $(this).data('email');
        var jobTitle = $(this).closest('.accordion-item').find('.accordion-button').text().trim();
        
        if (email) {
            // Show email options modal
            showEmailOptions(email, jobTitle);
        }
        
        return false;
    });
    
    function showEmailOptions(email, jobTitle) {
        var subject = encodeURIComponent('Application for: ' + jobTitle);
        var body = encodeURIComponent('Hello,\n\nI am interested in applying for the ' + jobTitle + ' position.\n\nBest regards');
        
        // Gmail compose URL
        var gmailUrl = 'https://mail.google.com/mail/?view=cm&to=' + email + '&su=' + subject + '&body=' + body;
        
        // Outlook compose URL  
        var outlookUrl = 'https://outlook.live.com/mail/0/deeplink/compose?to=' + email + '&subject=' + subject + '&body=' + body;
        
        // Yahoo compose URL
        var yahooUrl = 'https://compose.mail.yahoo.com/?to=' + email + '&subject=' + subject + '&body=' + body;
        
        var modal = $('<div class="email-options-modal">' +
                     '<div class="modal-content">' +
                     '<span class="close-modal">&times;</span>' +
                     '<h3>Choose Email Service</h3>' +
                     '<p>Select your preferred email service to compose your application:</p>' +
                     '<div class="email-buttons">' +
                     '<a href="' + gmailUrl + '" target="_blank" class="email-option gmail">📧 Gmail</a>' +
                     '<a href="' + outlookUrl + '" target="_blank" class="email-option outlook">📬 Outlook</a>' +
                     '<a href="' + yahooUrl + '" target="_blank" class="email-option yahoo">📮 Yahoo</a>' +
                     '<button class="email-option copy-email" data-email="' + email + '">📋 Copy Email</button>' +
                     '</div>' +
                     '<p class="email-display">Email: <strong>' + email + '</strong></p>' +
                     '</div>' +
                     '</div>');
        
        // Add modal styles
        var modalStyles = `
            .email-options-modal {
                display: flex;
                position: fixed;
                z-index: 10000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                align-items: center;
                justify-content: center;
            }
            .email-options-modal .modal-content {
                background-color: #fff;
                padding: 30px;
                border-radius: 10px;
                max-width: 500px;
                text-align: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            }
            .email-options-modal h3 {
                color: #003A51;
                margin-bottom: 15px;
                font-size: 24px;
            }
            .email-options-modal p {
                color: #666;
                margin-bottom: 20px;
            }
            .email-options-modal .email-buttons {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                margin-bottom: 20px;
            }
            .email-options-modal .email-option {
                display: block;
                padding: 15px 20px;
                border: 2px solid #ddd;
                border-radius: 8px;
                text-decoration: none;
                color: #333;
                font-weight: 500;
                transition: all 0.3s ease;
                cursor: pointer;
                background: #f9f9f9;
            }
            .email-options-modal .email-option:hover {
                border-color: #008c61;
                background: #008c61;
                color: white;
                transform: translateY(-2px);
            }
            .email-options-modal .close-modal {
                float: right;
                font-size: 28px;
                cursor: pointer;
                margin-top: -10px;
                color: #999;
            }
            .email-options-modal .email-display {
                font-size: 14px;
                color: #999;
                border-top: 1px solid #eee;
                padding-top: 15px;
                margin-top: 15px;
            }
        `;
        
        if (!$('#email-options-styles').length) {
            $('<style id="email-options-styles">' + modalStyles + '</style>').appendTo('head');
        }
        
        $('body').append(modal);
        
        // Close modal events
        modal.find('.close-modal').on('click', function() {
            modal.remove();
        });
        
        modal.on('click', function(e) {
            if (e.target === this) {
                modal.remove();
            }
        });
        
        // Copy email functionality
        modal.find('.copy-email').on('click', function() {
            var emailToCopy = $(this).data('email');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(emailToCopy).then(function() {
                    alert('Email copied to clipboard: ' + emailToCopy);
                    modal.remove();
                });
            }
        });
        
        // Close modal when clicking email service links
        modal.find('.email-option:not(.copy-email)').on('click', function() {
            setTimeout(function() {
                modal.remove();
            }, 1000);
        });
    }
});
