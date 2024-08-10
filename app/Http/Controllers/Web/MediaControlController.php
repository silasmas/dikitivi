<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaView;
use App\Models\Notification;
use App\Models\Session;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Media as ResourcesMedia;
use App\Http\Resources\MediaView as ResourcesMediaView;
use App\Http\Resources\Session as ResourcesSession;
use App\Http\Resources\User as ResourcesUser;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class MediaControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $for_youth
     * @return \Illuminate\Http\Response
     */
    public function allByAge($for_youth)
    {
        $query_all = Media::orderByDesc('created_at')->paginate(12);
        $query_child = Media::where('for_youth', $for_youth)->orderByDesc('created_at')->paginate(12);
        $medias = $for_youth == 0 ? $query_all : $query_child;

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));
    }

    /**
     * Find current trends.
     *
     * @param  string $year
     * @param  int $for_youth
     * @return \Illuminate\Http\Response
     */
    public function trends($year, $for_youth)
    {
        $query_all = Media::whereHas('sessions', function ($query) use ($year) {$query->whereYear('sessions.created_at', '=', $year);})->distinct()->orderByDesc('created_at')->limit(5)->get();
        $query_child = Media::where('for_youth', $for_youth)->whereHas('sessions', function ($query) use ($year) {$query->whereYear('sessions.created_at', '=', $year);})->distinct()->orderByDesc('created_at')->limit(5)->get();
        $medias = $for_youth == 0 ? $query_all : $query_child;

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), null, count($medias));
    }

    /**
     * Get all by title.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $data
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $data)
    {
        $medias = Media::where('media_title', 'LIKE', '%' . $data . '%')->orderByDesc('created_at')->paginate(12);
        $count_all = Media::where('media_title', 'LIKE', '%' . $data . '%')->count();

        if ($request->hasHeader('X-user-id') and $request->hasHeader('X-ip-address')) {
            $session = Session::where('user_id', $request->header('X-user-id'))->first();

            if (!empty($session)) {
                if (count($session->medias) == 0) {
                    $session->medias()->attach($medias->pluck('id'));
                }

                if (count($session->medias) > 0) {
                    $session->medias()->syncWithoutDetaching($medias->pluck('id'));
                }
            }

        } else {
            if ($request->hasHeader('X-user-id') and !$request->hasHeader('X-ip-address')) {
                $session = Session::where('user_id', $request->header('X-user-id'))->first();

                if (!empty($session)) {
                    if (count($session->medias) == 0) {
                        $session->medias()->attach($medias->pluck('id'));
                    }

                    if (count($session->medias) > 0) {
                        $session->medias()->syncWithoutDetaching($medias->pluck('id'));
                    }
                }

            } else {
                if ($request->hasHeader('X-ip-address')) {
                    $session = Session::where('ip_address', $request->header('X-ip-address'))->first();

                    if (!empty($session)) {
                        if (count($session->medias) == 0) {
                            $session->medias()->attach($medias->pluck('id'));
                        }

                        if (count($session->medias) > 0) {
                            $session->medias()->syncWithoutDetaching($medias->pluck('id'));
                        }
                    }
                }
            }
        }

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), $count_all);
    }

    /**
     * Get all belonging to a media.
     *
     * @param  int $media_id
     * @return \Illuminate\Http\Response
     */
    public function findByBelongsTo($media_id)
    {
        $medias = Media::where('belongs_to', $media_id)->orderByDesc('created_at')->paginate(12);
        $count_all = Media::where('belongs_to', $media_id)->count();

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), $count_all);
    }

    /**
     * Get by type.
     *
     * @param  int $for_youth
     * @return \Illuminate\Http\Response
     */
    public function findLive($for_youth)
    {
        $type = Type::where('type_name->fr', 'Programme TV')->first();

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }
        $query_all = Media::where([['is_live', 1], ['type_id', $type->id]])->orderByDesc('created_at')->paginate(12);
        $query_child = Media::where([['for_youth', 1], ['is_live', $for_youth], ['type_id', $type->id]])->orderByDesc('created_at')->paginate(12);
        $medias = $for_youth == 0 ? $query_all : $query_child;

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));
    }

    /**
     * Get by user.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function findAllByUser($user_id)
    {
        $user = User::find($user_id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        $medias = Media::where('user_id', $user->id)->orderByDesc('updated_at')->paginate(12);
        $count_all = Media::where('user_id', $user->id)->count();

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), $count_all);
    }

    /**
     * Get by type.
     *
     * @param  string $locale
     * @param  string $type_name
     * @return \Illuminate\Http\Response
     */
    public function findAllByType($locale, $type_name)
    {
        $type = Type::where('type_name->' . $locale, $type_name)->first();

        if (is_null($type)) {
            return $this->handleError(__('notifications.find_type_404'));
        }

        $medias = Media::where('type_id', $type->id)->orderByDesc('created_at')->get();
        $count_all = Media::where('type_id', $type->id)->count();

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), null, $count_all);
    }

    /**
     * Get by age and type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $for_youth
     * @param  int $type_id
     * @return \Illuminate\Http\Response
     */
    public function findAllByAgeType(Request $request, $for_youth, $type_id)
    {
        $query_all = Media::where('type_id', $type_id)->orderByDesc('created_at')->paginate(12);
        $query_session_user_all = Media::whereHas('sessions', function ($query) use ($request) {$query->where('sessions.user_id', $request->header('X-user-id'));})->where('medias.type_id', $type_id)->orderByDesc('medias.created_at')->paginate(12);
        $query_session_ip_address_all = Media::whereHas('sessions', function ($query) use ($request) {$query->where('sessions.ip_address', $request->header('X-ip-address'));})->where('medias.type_id', $type_id)->orderByDesc('medias.created_at')->paginate(12);
        $query_child = Media::where([['for_youth', $for_youth], ['type_id', $type_id]])->orderByDesc('created_at')->paginate(12);
        $query_session_user_child = Media::where([['medias.for_youth', $for_youth], ['medias.type_id', $type_id]])->whereHas('sessions', function ($query) use ($request) {$query->where('sessions.user_id', $request->header('X-user-id'));})->orderByDesc('medias.created_at')->paginate(12);
        $query_session_ip_address_child = Media::where([['medias.for_youth', $for_youth], ['medias.type_id', $type_id]])->whereHas('sessions', function ($query) use ($request) {$query->where('sessions.ip_address', $request->header('X-ip-address'));})->orderByDesc('medias.created_at')->paginate(12);

        if ($request->hasHeader('X-user-id') and $request->hasHeader('X-ip-address')) {
            $sessions = Session::where('user_id', $request->header('X-user-id'))->get();

            if ($sessions == null) {
                $medias = $for_youth == 0 ? $query_all : $query_child;

                return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));

            } else {
                $session_medias = $for_youth == 0 ? $query_session_user_all : $query_session_user_child;
                $global_medias = $for_youth == 0 ? $query_all : $query_child;
                // Merged data
                $medias = ($session_medias->merge($global_medias))->unique();

                return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $global_medias->lastPage(), count($medias));
            }

        } else {
            if ($request->hasHeader('X-user-id') and !$request->hasHeader('X-ip-address')) {
                $sessions = Session::where('user_id', $request->header('X-user-id'))->get();

                if ($sessions == null) {
                    $medias = $for_youth == 0 ? $query_all : $query_child;

                    return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));

                } else {
                    $session_medias = $for_youth == 0 ? $query_session_user_all : $query_session_user_child;
                    $global_medias = $for_youth == 0 ? $query_all : $query_child;
                    // Merged data
                    $medias = ($session_medias->merge($global_medias))->unique();

                    return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $global_medias->lastPage(), count($medias));
                }

            } else if (!$request->hasHeader('X-user-id') and $request->hasHeader('X-ip-address')) {
                $sessions = Session::where('ip_address', $request->header('X-ip-address'))->get();

                if ($sessions == null) {
                    $medias = $for_youth == 0 ? $query_all : $query_child;

                    return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));

                } else {
                    $session_medias = $for_youth == 0 ? $query_session_ip_address_all : $query_session_ip_address_child;
                    $global_medias = $for_youth == 0 ? $query_all : $query_child;
                    // Merged data
                    $medias = ($session_medias->merge($global_medias))->unique();

                    return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $global_medias->lastPage(), count($medias));
                }

            } else {
                $medias = $for_youth == 0 ? $query_all : $query_child;

                return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));
            }
        }
    }

    /**
     * Find media views.
     *
     * @param  int  $media_id
     * @return \Illuminate\Http\Response
     */
    public function findViews($media_id)
    {
        $media = Media::find($media_id);

        if (is_null($media)) {
            return $this->handleError(__('notifications.find_media_404'));
        }

        $sessions = $media->sessions;
        $count_all = count($media->sessions);

        // $sessions = Session::whereHas('medias', function ($query) use ($media) {
        //     // $query->where('media_session.is_viewed', 1)
        //     $query->where('media_session.media_id', $media->id);
        // })->get();
        // $count_all = Session::whereHas('medias', function ($query) use ($media) {
        //     // $query->where('media_session.is_viewed', 1)
        //     $query->where('media_session.media_id', $media->id);
        // })->count();

        return $this->handleResponse(ResourcesSession::collection($sessions), __('notifications.find_all_sessions_success'), null, $count_all);
    }

    /**
     * Find media likes.
     *
     * @param  int  $media_id
     * @return \Illuminate\Http\Response
     */
    public function findLikes($media_id)
    {
        $media = Media::find($media_id);

        if (is_null($media)) {
            return $this->handleError(__('notifications.find_media_404'));
        }

        $users = $media->users;
        $count_all = count($media->users);

        // $users = User::whereHas('medias', function ($query) use ($media) {
        //     $query->where('media_user.is_liked', 1)
        //         ->where('media_user.media_id', $media->id);
        // })->get();
        // $count_all = User::whereHas('medias', function ($query) use ($media) {
        //     $query->where('media_user.is_liked', 1)
        //         ->where('media_user.media_id', $media->id);
        // })->count();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'), null, $count_all);
    }

    /**
     * Find medias viewed by a specific user.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function findViewedMedias($user_id)
    {
        $media_views = MediaView::where('user_id', $user_id)->orderByDesc('created_at')->get();
        $count_all = count($media_views);

        // $user = User::find($user_id);

        // if (is_null($user)) {
        //     return $this->handleError(__('notifications.find_user_404'));
        // }

        // $medias = Media::whereHas('sessions', function ($query) use ($user) {
        //                 // $query->where('media_session.is_viewed', 1)
        //                 $query->where('sessions.user_id', $user->id);
        //             })->paginate(12);
        // $count_all = Media::whereHas('sessions', function ($query) use ($user) {
        //                     // $query->where('media_session.is_viewed', 1)
        //                     $query->where('sessions.user_id', $user->id);
        //                 })->count();

        return $this->handleResponse(ResourcesMediaView::collection($media_views), __('notifications.find_all_medias_success'), null, $count_all);
    }

    /**
     * Check if the user liked media.
     *
     * @param  int  $media_id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function hasLiked($media_id, $user_id)
    {
        $media = Media::find($media_id);

        if (is_null($media)) {
            return $this->handleError(__('notifications.find_media_404'));
        }

        $user = User::find($user_id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        $users = User::whereHas('medias', function ($query) use ($media) {
            $query->where('media_user.is_liked', 1)
                ->where('media_user.media_id', $media->id)
                ->orderByDesc('media_user.created_at');
        })->get();

        if (inArrayR($user->username, $users, 'username')) {
            return $this->handleResponse(1, __('notifications.find_user_success'), null);

        } else {
            return $this->handleResponse(0, __('notifications.find_user_404'), null);
        }
    }

    /**
     * Find all medias liked by a user.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function favorites($user_id)
    {
        $user = User::find($user_id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        $medias = Media::whereHas('users', function ($query) use ($user) {
            $query->where('media_user.is_liked', 1)
                ->where('media_user.user_id', $user->id)
                ->orderByDesc('media_user.created_at');
        })->paginate(12);
        $count_all = Media::whereHas('users', function ($query) use ($user) {
            $query->where('media_user.is_liked', 1)
                ->where('media_user.user_id', $user->id)
                ->orderByDesc('media_user.created_at');
        })->count();

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), $count_all);
    }

    /**
     * Filter medias by categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $for_youth
     * @return \Illuminate\Http\Response
     */
    public function filterByCategories(Request $request, $for_youth)
    {
        $query_all = Media::whereHas('categories', function ($query) use ($request) {$query->whereIn('categories.id', $request->categories_ids);})->orderByDesc('medias.created_at')->paginate(12);
        $query_child = Media::where('for_youth', $for_youth)->whereHas('categories', function ($query) use ($request) {$query->whereIn('categories.id', $request->categories_ids);})->orderByDesc('medias.created_at')->paginate(12);
        $medias = $for_youth == 0 ? $query_all : $query_child;

        return $this->handleResponse(ResourcesMedia::collection($medias), __('notifications.find_all_medias_success'), $medias->lastPage(), count($medias));
    }

    /**
     * Switch the media view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $media_id
     * @return \Illuminate\Http\Response
     */
    public function switchView(Request $request, $media_id)
    {
        $media = Media::find($media_id);

        if (is_null($media)) {
            return $this->handleError(__('notifications.find_media_404'));
        }

        if (!empty($request->user_id) and !empty($request->ip_address) or !empty($request->user_id) and empty($request->ip_address)) {
            $session = Session::where('user_id', $request->user_id)->first();

            if (!empty($session)) {
                if (count($session->medias) == 0) {
                    $session->medias()->attach([$media->id => ['is_viewed' => 1]]);
                }

                if (count($session->medias) > 0) {
                    foreach ($session->medias as $med) {
                        $session->medias()->syncWithoutDetaching([$media->id => ['is_viewed' => ($med->pivot->is_viewed == 1 ? 0 : 1)]]);
                    }
                }

                if ($media->user_id != null) {
                    $status_unread = Status::where('status_name->fr', 'Non lue')->first();
                    $visitor = User::find($request->user_id);

                    /*
                    HISTORY AND/OR NOTIFICATION MANAGEMENT
                     */
                    if (!empty($visitor)) {
                        Notification::create([
                            'notification_url' => 'members/' . $visitor->id,
                            'notification_content' => [
                                'en' => $visitor->firstname . ' watched your ' . $media->type->type_name->en . '.',
                                'fr' => $visitor->firstname . ' a regardé votre ' . $media->type->type_name->fr . '.',
                                'ln' => $visitor->firstname . ' atali ' . $media->type->type_name->ln . ' na yo.',
                            ],
                            'icon' => 'bi bi-eye',
                            'color' => 'text-warning',
                            'status_id' => $status_unread->id,
                            'user_id' => $media->user_id,
                        ]);
                    }
                }
            }
        }

        if (empty($request->user_id) and !empty($request->ip_address)) {
            $session = Session::where('ip_address', $request->ip_address)->first();

            if (!empty($session)) {
                if ($session->medias() == null) {
                    $session->medias()->attach([$media->id => ['is_viewed' => 1]]);
                }

                if ($session->medias() != null) {
                    foreach ($session->medias as $med) {
                        $session->medias()->syncWithoutDetaching([$media->id => ['is_viewed' => ($med->pivot->is_viewed == 1 ? 0 : 1)]]);
                    }
                }
            }
        }
    }

    /**
     * Switch the media like.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $user_id
     * @param  int $media_id
     * @return \Illuminate\Http\Response
     */
    public function switchLike(Request $request, $user_id, $media_id)
    {
        $user = User::find($user_id);
        $media = Media::find($media_id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        if (is_null($media)) {
            return $this->handleError(__('notifications.find_media_404'));
        }

        if (count($user->medias) == 0) {
            $user->medias()->attach([$media->id => ['is_liked' => 1]]);
        }

        if (count($user->medias) > 0) {
            if (inArrayR($media->media_title, $user->medias, 'media_title')) {
                foreach ($user->medias as $med):
                    if ($med->id == $media->id) {
                        $user->medias()->updateExistingPivot($media->id, ['is_liked' => ($med->pivot->is_liked == 1 ? 0 : 1)]);
                    }
                endforeach;

            } else {
                $user->medias()->attach([$media->id => ['is_liked' => 1]]);
            }
        }

        if ($media->user_id != null) {
            $status_unread = Status::where('status_name->fr', 'Non lue')->first();
            $visitor = User::find($request->header('X-user-id'));

            /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
             */
            if (!empty($visitor)) {
                Notification::create([
                    'notification_url' => 'members/' . $visitor->id,
                    'notification_content' => [
                        'en' => $visitor->firstname . ' liked your ' . $media->type->type_name->en . '.',
                        'fr' => $visitor->firstname . ' a aimé votre ' . $media->type->type_name->fr . '.',
                        'ln' => $visitor->firstname . ' alingi ' . $media->type->type_name->ln . ' na yo.',
                    ],
                    'icon' => 'bi bi-eye',
                    'color' => 'text-warning',
                    'status_id' => $status_unread->id,
                    'user_id' => $media->user_id,
                ]);
            }
        }

        return $this->handleResponse(new ResourcesMedia($media), __('notifications.find_media_success'));
    }

    /**
     * Approve the media.
     *
     * @param  int $user_id
     * @param  int $media_id
     * @param  int $status_id
     * @return \Illuminate\Http\Response
     */
    public function setApprobation($user_id, $media_id, $status_id)
    {
        $user = User::find($user_id);
        $media = Media::find($media_id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        if (is_null($media)) {
            return $this->handleError(__('notifications.find_media_404'));
        }

        if (count($user->medias) == 0) {
            $user->medias()->attach([$media->id => [
                'status_id' => $status_id,
            ]]);
        }

        if (count($user->medias) > 0) {
            if (inArrayR($media->id, $user->medias, 'media_id')) {
                foreach ($user->medias as $med):
                    if ($med->id == $media->id) {
                        $user->medias()->updateExistingPivot($media->id, ['status_id' => $status_id]);
                    }
                endforeach;

            } else {
                $user->medias()->attach([$media->id => [
                    'status_id' => $status_id,
                ]]);
            }
        }

        return $this->handleResponse(new ResourcesMedia($media), __('notifications.find_media_success'));
    }
}
