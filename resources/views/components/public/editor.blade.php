<div class="editor">
    <div class="editor__form">
        <div class="editor__textarea" style='--placeholder: "What’s on your mind?"' contenteditable="true" placeholder="{{ __("What's on your mind?") }}"></div>
        <div class="editor__actions">
            <label for="editor-media">
                <i class="icon icon-media"></i>
                {{__("Add Photo/Video")}}
            </label>
            <button class="button" type="submit">{{ __('Post') }}</button>
        </div>
        <input type="file" name="media" id="editor-media" class="editor__media" accept="image/*, video/*">
    </div>
</div>
