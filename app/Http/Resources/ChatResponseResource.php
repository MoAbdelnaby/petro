<?php

namespace App\Http\Resources;

use App\ChatResponse;
use App\ChatResponseItemButton;
use App\ChatResponseItemCard;
use App\ChatResponseItemEnd;
use App\ChatResponseItemImage;
use App\ChatResponseItemMultiCard;
use App\ChatResponseItemPdf;
use App\ChatResponseItemQuestion;
use App\ChatResponseItemText;
use App\ChatResponseItemTransferring;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $responses = ChatResponse::where('group', $request->id)
            ->with([
                'chat',
                'items',
                'says',
                'language',
            ])
            ->get();

        $json = [
            'responses' => [

            ]
        ];

        foreach ($responses as $response) {
            $json['responses'][] = [
                "language" => $response->language->code,
                "id" => $response->id,
                "items" => [],
                "says" => $response->says->pluck('text')
            ];

            $ref = &$json['responses'][count($json['responses']) - 1]['items'];
            foreach ($response->items as $item) {
                switch ($item->detail_type) {
                    case ChatResponseItemText::class:
                        $ref[] = [
                            "type" => "text",
                            "details" => [
                                "text" => $item->detail->text
                            ]
                        ];
                        break;
                    case ChatResponseItemEnd::class:
                        $ref[] = [
                            "type" => "end",
                            "details" => [
                                "text" => $item->detail->text
                            ]
                        ];
                        break;
                    case ChatResponseItemTransferring::class:
                        $ref[] = [
                            "type" => "transferring",
                            "details" => [
                                "text" => $item->detail->text,
                                "live_chat_group_id" => $item->detail->live_chat_group_id,
                            ]
                        ];
                        break;
                    case ChatResponseItemQuestion::class:
                        $ref[] = [
                            "type" => "question",
                            "details" => [
                                "text" => $item->detail->text,
                                "required" => $item->detail->required,
                                "validate" => $item->detail->validate,
                                "error_message" => $item->detail->error_message,
                                "next_chat_response_group" => $item->detail->next_chat_response_group,
                            ]
                        ];
                        break;
                    case ChatResponseItemButton::class:
                        $ref[] = [
                            "type" => "button",
                            "details" => [
                                "text" => $item->detail->text,
                                "actionType" => $item->detail->type,
                                "action" => $item->detail->action,
                            ]
                        ];
                        break;
                    case ChatResponseItemImage::class:
                        $ref[] = [
                            "type" => "image",
                            "details" => [
                                "image" => $item->detail->image,
                            ]
                        ];
                        break;
                    case ChatResponseItemPdf::class:
                        $ref[] = [
                            "type" => "pdf",
                            "details" => [
                                "pdf" => $item->detail->pdf,
                            ]
                        ];
                        break;
                    case ChatResponseItemCard::class:
                        $ref[] = [
                            "type" => "card",
                            "details" => [
                                'image' => $item->detail->image,
                                'title' => $item->detail->title,
                                'text' => $item->detail->text,
                                'user_id' => $item->detail->user_id,
                                'chat_response_item_multi_card_id' => $item->detail->chat_response_item_multi_card_id,
                                'buttons' => []
                            ]
                        ];
                        // load buttons
                        if ($item->detail->buttons->count()) {
                            foreach ($item->detail->buttons as $button) {
                                $ref[count($ref) - 1]['details']['buttons'][] = [
                                    "type" => "button",
                                    "details" => [
                                        "text" => $button->text,
                                        "actionType" => $button->type,
                                        "action" => $button->action,
                                    ]
                                ];
                            }
                        }
                        break;
                    case ChatResponseItemMultiCard::class:
                        $ref[] = [
                            "type" => "multiCard",
                            "details" => [
                                "cards" => [],
                            ]
                        ];

                        if ($item->detail->cards->count()) {
                            foreach ($item->detail->cards as $card) {
                                $ref[count($ref) - 1]['details']['cards'][] = [
                                    "type" => "card",
                                    "details" => [
                                        'image' => $card->image,
                                        'title' => $card->title,
                                        'text' => $card->text,
                                        'user_id' => $card->user_id,
                                        'chat_response_item_multi_card_id' => $card->chat_response_item_multi_card_id,
                                        'buttons' => []
                                    ]
                                ];
                                // load buttons
                                if ($card->buttons->count()) {
                                    foreach ($card->buttons as $button) {
                                        $ref[count($ref) - 1]['details']['cards'][count($ref[count($ref) - 1]['details']['cards']) - 1]['details']['buttons'][] = [
                                            "type" => "button",
                                            "details" => [
                                                "text" => $button->text,
                                                "actionType" => $button->type,
                                                "action" => $button->action,
                                            ]
                                        ];
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        }

        return $json;
    }
}
