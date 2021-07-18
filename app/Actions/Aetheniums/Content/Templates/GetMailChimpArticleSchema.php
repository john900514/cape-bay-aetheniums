<?php

namespace App\Actions\Aetheniums\Content\Templates;

use Lorisleiva\Actions\Concerns\AsAction;

class GetMailChimpArticleSchema
{
    use AsAction;

    public function handle(array $extras)
    {
        $results = [];

        // @todo - use the 'extras' variable to replace the placeholder structure
        $results['banner_img'] = [
            'src' => $extras['banner_img'] ?? 'https://mailchimp.com/developer/track-email-with-webhooks-header.svg',
        ];

        $results['sections'] = [];

        if(array_key_exists('sections', $extras))
        {
            $sections = json_decode($extras['sections'], true);

            foreach ($sections as $idx => $section)
            {
                $next_section = [
                    'title' => '',
                    'subsections'=> []
                ];

                if(array_key_exists('title', $section))
                {
                    $next_section['title'] = $section['title'];
                }

                if(array_key_exists('subsections', $section) && is_array($section['subsections']) && (count($section['subsections']) > 0))
                {
                    foreach ($section['subsections'] as $elem => $subsection)
                    {
                        switch($subsection['type'])
                        {
                            case 'textbody':
                                $next_section['subsections'][$elem] = [
                                    'type' => $subsection['type'],
                                    'content'=> $subsection['properties']['content']
                                ];
                                break;

                            case 'content-tip':
                                $next_section['subsections'][$elem] = [
                                    'type' => $subsection['type'],
                                    'tip-border-color' => $subsection['properties']['tipBorderColor'],
                                    //'content-text-color' => 'text-black',
                                    'icon' => $subsection['properties']['icon'],
                                    'icon-color' => $subsection['properties']['iconColor'],
                                    'content'=> $subsection['properties']['content']
                                ];
                                break;

                            case 'code-highlight':
                                $next_section['subsections'][$elem] = [
                                    'type' => $subsection['type'],
                                    'code'=> $subsection['properties']['code'],
                                    'language'=> $subsection['properties']['language'],
                                ];
                                break;
                        }
                    }
                }

                $results['sections'][$idx] = $next_section;
            }
        }

        /*
        $results['sections'] = [
            [
                'title' => 'At a glance',
                'subsections' => [
                    [
                        'type' => 'textbody',
                        'content' => '<p>Webhooks allow your application to receive information about email events as they occur, and respond in a way that you define. You can <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/docs/webhooks/#test-and-debug-webhooks" href="/developer/transactional/docs/webhooks/#test-and-debug-webhooks"><u>configure and test webhooks</u></a> via the <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="https://mandrillapp.com/settings/webhooks" rel="noopener noreferrer" target="_blank" href="https://mandrillapp.com/settings/webhooks"><b><u>Webhooks</u></b></a> page in your Mailchimp Transactional app, or you can do so via <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/api/webhooks" href="/developer/transactional/api/webhooks/">the API</a>.&nbsp;</p><p>You could use webhooks to:&nbsp;</p>',
                    ],
                    [
                        'type' => 'ul',
                        'content' => [
                            'Create your own custom reporting dashboard using webhook data',
                            'Keep your CRM in sync with events from Mailchimp Transactional ',
                            'Store data about your emails for longer than 30 days'
                        ],
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>For the purposes of this guide, we run a plant delivery website called Eiffel Flowers. In the course of our business, we send registered users a variety of transactional emails.&nbsp;</p><p>In this guide, we’ll set up a webhook that will trigger when a particular link is clicked in one of our emails, which will allow us to then send a follow-up email advertising a relevant flower sale. We’ll walk through how to create the webhook, and then we’ll write code to handle the incoming webhook data and send a follow-up email in response.</p>',
                    ],
                ]
            ],
            [
                'title' => 'What You\'ll Need',
                'subsections' => [
                    [
                        'type' => 'ul',
                        'content' => [
                            '<p>A Mailchimp Transactional account</p>',
                            '<p>A callback URL for your application that can accept HTTP POST requests</p>',
                            '<p><a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/guides/quick-start/" href="/developer/transactional/guides/quick-start/"><u>Your API key</u></a></p>'
                        ],
                    ],
                ]
            ],
            [
                'title' => 'Create a new webhook',
                'subsections' => [
                    [
                        'type' => 'textbody',
                        'content' => '<p>First, let’s set up our webhook, which will be triggered when subscribers click a link in one of our plant emails. There are two ways to do this: using the Mailchimp Transactional app or <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/api/webhooks/add-webhook" href="/developer/transactional/api/webhooks/add-webhook/">through the API</a>. In this guide, we’ll walk through setting it up using the app.&nbsp;</p><p>To set up a webhook:&nbsp;</p>',
                    ],
                    [
                        'type' => 'ol',
                        'content' => [
                            '<p>Navigate to <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="https://mandrillapp.com/settings/webhooks" rel="noopener noreferrer" target="_blank" href="https://mandrillapp.com/settings/webhooks"><u><b>Webhooks</b></u></a> and click <b>Add a Webhook</b> at the top of the page</p>',
                            '<p>Choose the events you want to listen for in the “Trigger on Events” section (e.g., when an email is sent, bounces, is opened, is marked as spam, is clicked)</p>',
                            '<p>In the “Post To URL” field, input the callback URL your application will use to accept the incoming webhook</p>',
                            '<p>Give your webhook an optional description under <b>Description</b></p>',
                            '<p>Click <b>Create Webhook</b></p>',
                        ],
                    ],
                    [
                        'type' => 'content-tip',
                        'tip-border-color' => 'border-success',
                        //'content-text-color' => 'text-black',
                        'icon' => 'la la-automobile',
                        'icon-color' => 'text-success',
                        'content' => '<p><b>Note</b>: Your webhook callback URL should be set up to accept POST requests at a minimum. When you provide the URL where you want Mailchimp to POST the event data, a HEAD request will be sent to the URL to check that it exists.</p><p>If the URL doesn\'t exist or returns something other than a 200 HTTP response to the HEAD request, Mailchimp will fall back and attempt a POST request. In this case, the POST request’s <code>mandrill_events</code> parameter will be an empty array, and the POST will be <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/docs/webhooks/#test-and-debug-webhooks" href="/developer/transactional/docs/webhooks/#test-and-debug-webhooks">signed</a> with a generic key (with the value <code>test-webhook</code>).</p>'
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>For a full overview of webhook formatting and configuration in Mailchimp Transactional, see the <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/docs/webhooks/#the-basics" href="/developer/transactional/docs/webhooks/#the-basics">Webhooks docs</a>. </p>'
                    ]
                ],
            ],
            [
                'title' => 'Handling the webhook response in your app',
                'subsections' => [
                    [
                        'type' => 'textbody',
                        'content' => '<p>Now that we have the webhook set up, we need to handle the webhook data on the server that the webhook URL we provided points to.&nbsp;</p><p>The body of the webhook request, parsed as JSON, will look something like this: </p>'
                    ],
                    [
                        'type' => 'code-highlight',
                        'language' => 'json',
                        'code' => '
{
    "mandrill_events": [
        {
          "event": "open",
          "msg": {
            "ts": 1365109999,
            "subject": "Roses Are Red, Violets Are On Sale",
            "email": "flowerfriend@example.com",
            "sender": "hello@eiffelflowers.biz",
            "tags": ["violets"],
            "opens": [
              {
                "ts": 1365111111
              }
            ],
            "clicks": [
              {
                "ts": 1365111111,
                "url": "https://www.eiffelflowers.biz/news/ultraviolet-sale"
              }
            ],
            "state": "sent",
            "metadata": {
              "user_id": 111
            },
            "_id": "7761629",
            "_version": "123"
            # trimmed for brevity
          }
        }
      ]
    }'
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>Now that we have the webhook set up, we need to handle the webhook data on the server that the webhook URL we provided points to.&nbsp;</p><p>The body of the webhook request, parsed as JSON, will look something like this: </p>'
                    ],
                    [
                        'type' => 'code-highlight',
                        'language' => 'php',
                        'code' => '
<?php
const TARGET_LINK_URL = "https://www.eiffelflowers.biz/news/ultraviolet-sale";
function generateEmail($email) {
  $message = new stdClass();
  $to = new stdClass();
  $to->email = $email;
  $to->type = \'to\';
  $message->html = \'<p>We noticed you were interested in violets! How about we offer you a great deal on a dozen if you buy in the next 72 hours?</p>\';
  $message->text = \'We noticed you were interested in violets! How about we offer you a great deal on a dozen if you buy in the next 72 hours?\';
  $message->subject = \'Roses Are Red, Violets Are On Sale\';
  $message->from_email = \'hello@eiffelflowers.biz\';
  $message->from_name = \'Daisy @ Eiffel Flowers\';
  $message->to = [$to];
  return $message;
}
if ($_SERVER[\'REQUEST_METHOD\'] === \'POST\') {
  $mandrillEvents = json_decode($_POST[\'mandrill_events\']);
  foreach ($mandrillEvents as $event) {
    $url = $event->msg->clicks[0];
    $email = $event->msg->email;
    echo "url: $url";
    if ($url === TARGET_LINK_URL) {
      // send follow-up message here using the Mailchimp Transactional API
      // for more details, see https://mailchimp.com/developer/guides/send-your-first-transactional-email
      echo \'Send follow up email with this payload:\' . generateMessage($email);
    } else {
      // lets us test the webhook using the Mailchimp Transactional UI (see next section)
      echo \'webhook handled successfully!\';
    }
  }
  echo \'Done\';
}

                        '
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>You can find a full index of detailed webhook format responses in the <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/docs/webhooks/#detailed-webhook-format-responses" href="/developer/transactional/docs/webhooks/#detailed-webhook-format-responses">Webhooks docs</a>.</p>'
                    ],
                ],
            ],
            [
                'title' => 'Test the webhook',
                'subsections' => [
                    [
                        'type' => 'textbody',
                        'content' => '<p>Now let’s run a simple test of the webhook without sending any emails. First, head back to<a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="https://mandrillapp.com/settings/webhooks" rel="noopener noreferrer" target="_blank" href="https://mandrillapp.com/settings/webhooks"> <b><u>Webhooks</u></b></a>. Find the entry for your webhook and click the <b>Send Test</b> button.&nbsp;</p><p>If your webhook handler is working, you should find the message <code>webhook handled successfully!</code> in your server logs.</p><p>To test the webhook further, you’ll need to send an email containing a link with the <code>TARGET_LINK_URL</code> we used above, then have the recipient click the link. At that point, our handler should trigger, sending our follow-up email.</p><p>For more information about testing and debugging webhooks, see the <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/docs/webhooks/#test-and-debug-webhooks" href="/developer/transactional/docs/webhooks/#test-and-debug-webhooks">Webhooks docs</a>.</p>'
                    ],
                ]
            ],
            [
                'title' => 'Authenticating webhook requests',
                'subsections' => [
                    [
                        'type' => 'textbody',
                        'content' => '<p>Finally, since our app exposes sensitive data—you know what plant-selling is like!—we’re going to want to ensure that requests are coming from Mailchimp Transactional rather than an imitator. Mailchimp signs all webhook requests, allowing you to verify that incoming requests weren’t generated by some nefarious third party. This step isn’t required, but it is recommended.</p><p>First, we need to get our webhook authentication key. When you create a webhook via the Mailchimp Transactional app, a signing key is automatically generated. You’ll need this key to generate a signature in your code, and compare that to the signature that Mailchimp sent.</p><p>If you’re using the <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/api/webhooks/add-webhook/" href="/developer/transactional/api/webhooks/add-webhook/"><code><u>webhooks/add</u></code></a> method, the key will be returned in the response. You can also view and reset the key from the <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="https://mandrillapp.com/settings/webhooks" rel="noopener noreferrer" target="_blank" href="https://mandrillapp.com/settings/webhooks"><b><u>Webhooks</u></b></a><b> </b>page in your account. To retrieve a webhook key via the Transactional API, use <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/api/webhooks/get-webhook-info/" href="/developer/transactional/api/webhooks/get-webhook-info/"><code><u>webhooks/info</u></code></a> or <a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/api/webhooks/list-webhooks/" href="/developer/transactional/api/webhooks/list-webhooks/"><code><u>webhooks/list</u></code></a>.</p><p>Next, we need to generate a signature. Mailchimp signs each webhook request using the following process:</p>'
                    ],
                    [
                        'type' => 'ol',
                        'content' => [
                            '<p>Create a string with the webhook’s URL, exactly as you entered it in Mailchimp Transactional (including any query strings, if applicable)</p>',
                            '<p>Sort the request’s POST variables alphabetically by key</p>',
                            '<p>Append each POST variable’s key and value to the URL string, with no delimiter</p>',
                            '<p>Hash the resulting string with HMAC-SHA1, using your webhook’s authentication key to generate a binary signature</p>',
                            '<p>Base64 encode the binary signature</p>',
                        ],
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>Mailchimp includes an <code>X-Mandrill-Signature</code> HTTP header with webhook POST requests; this header will contain the signature for the request. To verify a webhook request, you’ll need to generate a signature using the same method and key that Mailchimp Transactional uses and compare that to the value of the <code>X-Mandrill-Signature</code> header. </p>'
                    ],
                    [
                        'type' => 'content-tip',
                        'tip-border-color' => 'border-success',
                        //'content-text-color' => 'text-black',
                        //'icon' => 'la la-automobile',
                        'icon-color' => 'text-success',
                        'content' => '<p><b>Note</b>: Some HMAC implementations can generate either a binary or hexadecimal signature. Mailchimp generates a binary signature and then Base64-encodes it; using a hexadecimal signature will not work.</p>'
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>A function to accomplish this task may look something like:</p>'
                    ],
                    [
                        'type' => 'code-highlight',
                        'language' => 'javascript',
                        'code' => "
const crypto = require('crypto');

function generateSignature(webhook_key, url, params) {
    var signed_data = url;
    const param_keys = Object.keys(params);
    param_keys.sort();
    param_keys.forEach(function (key) {
        signed_data += key + params[key];
    });

    hmac = crypto.createHmac('sha1', webhook_key);
    hmac.update(signed_data);

    return hmac.digest('base64');
}
"
                    ],
                    [
                        'type' => 'textbody',
                        'content' => '<p>You can reset a webhook’s authentication key at any time, and Mailchimp Transactional will immediately begin using the new key to sign requests.&nbsp;</p><p>To ensure that you don’t lose any webhook batches between the time you reset your key and when you update your application to start using that new key, your webhook processor should reject batches with failed signatures with a non-200 status code. Mailchimp will queue the batch and retry later, which will give you time to update your application with the new key.</p>'
                    ],
                ]
            ],
            [
                'title' => 'More Resources',
                'subsections' => [
                    [
                        'type' => 'ul',
                        'content' => [
                            '<p><a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/docs/webhooks/" href="/developer/transactional/docs/webhooks/">Webhooks documentation</a></p>',
                            '<p><a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/guides/send-first-email/" href="/developer/transactional/guides/send-first-email/"><u>Send Your First Transactional Email</u></a></p>',
                            '<p><a class="ga_outbound" data-ctacategory="outbound" data-type="inline" data-url="/transactional/guides/change-behavior-rules-engine/" href="/developer/transactional/guides/change-behavior-rules-engine/"><u>Change Sending Behavior with the Rules Engine</u></a></p>'
                        ],
                    ],
                ]
            ],
        ];
*/
        return $results;
    }
}

