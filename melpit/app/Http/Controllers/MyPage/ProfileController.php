<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\Mypage\Profile\EditRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    //
    public function showProfileEditForm()
    {
        return view('mypage.profile_edit_form')
            ->with('user', Auth::user());
    }

    public function editProfile(EditRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->input('name');

        if($request->has('avatar')) {
            $fileName = $this->saveAvatar($request->file('avatar'));
            $user->avatar_file_name = $fileName;
        }
        $user->save();

        return redirect()->back()
            ->with('status', 'プロフィール変更しました。');

    }

    /** 
     * アバターの画像をリサイズして保存
     * 
     * @param UploadedFile $file アップロードされたアバター画像
     * @return string ファイル名
     */
    private function saveAvatar(UploadedFile $file): string
    {
        // 一時ファイルを生成してパスを取得する
        $tempPath = $this->makeTempPath();

        // Intervention Image を使用して画像をリサイズし、一時ファイルに保存
        Image::make($file)->fit(200, 200)->save($tempPath);

        // storageファサードを使用して画像をディスクに保存する
        $filePath = Storage::disk('public')
            ->putFile('avatars', new File($tempPath));

            return basename($filePath);
    }

    /**
     * 一時的なファイルを生成してパスを返す
     * 
     * @return string ファイルパス
     */
    private function makeTempPath() {
        // 一時ファイルを生成する
        $tmp_fp = tmpfile();
        // メタ情報が連想配列で入っているので
        // returnでファイルのパスだけ返す
        $meta = stream_get_meta_data($tmp_fp);
        return $meta["uri"];
    }


}
