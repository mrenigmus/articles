<template>
    <!-- Контейнер редактора Tiptap -->
    <div class="tiptap-container" v-if="editor">
        <!-- Панель форматирования -->
        <div class="tiptap-format-buttons">
            <!-- Кнопки форматирования текста -->
            <button @click="editor.commands.toggleBold" :class="{
                'active': editor.isActive('bold')
            }" class="button button-format"><i class="fas fa-bold"></i></button>
            <button @click="editor.commands.toggleItalic" :class="{
                'active': editor.isActive('italic')
            }" class="button button-format"><i class="fas fa-italic"></i></button>
            <button @click="editor.commands.toggleUnderline" :class="{
                'active': editor.isActive('underline')
            }" class="button button-format"><i class="fas fa-underline"></i></button>
            <button @click="editor.commands.toggleStrike" :class="{
                'active': editor.isActive('strike')
            }" class="button button-format"><i class="fas fa-strikethrough"></i></button>
            <!-- Кнопка для добавления ссылки -->
            <button @click="editor.commands.unsetLink" :class="{
                'active': editor.isActive('link')
            }" v-if="editor.isActive('link')" class="button button-format"><i class="fas fa-link"></i></button>
            <!-- Форма добавления ссылки -->
            <Popper ref="inputPopper" v-else>
                <button class="button button-format"><i class="fas fa-link"></i></button>
                <template #content>
                    <form @submit.prevent="addLink" class="form">
                        <input type="url" v-model="inputLink" placeholder="Введите ссылку" class="input">
                        <button type="submit" class="button">Добавить</button>
                    </form>
                </template>
            </Popper>
            <!-- Кнопка для переключения на режим кода -->
            <button @click="editor.commands.toggleCode" :class="{
                'active': editor.isActive('code')
            }" class="button button-format"><i class="fas fa-code"></i></button>
            <!-- Попап для выбора эмодзи -->
            <Popper class="emoji-picker-popper">
                <button class="button button-format"><i class="far fa-smile"></i></button>
                <template #content>
                    <EmojiPicker @select="insertEmoji" :native="true" :hide-search="true" :hide-group-names="true" :disable-sticky-group-names="true" :disable-skin-tones="true" />
                </template>
            </Popper>
        </div>
        <!-- Редактор контента -->
        <editor-content placeholder="Введите текст сообщения" spellcheck="false" :editor="editor" />
        <!-- Счётчик символов -->
        <small class="tiptap-text-limit text-muted">{{ editor.storage.characterCount.characters() }}/{{ limit}}</small>
    </div>
</template>

<script lang="ts">
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import { defineComponent } from 'vue'
import Underline from '@tiptap/extension-underline'
import Link from '@tiptap/extension-link'
import Placeholder from '@tiptap/extension-placeholder'
import CharacterCount from '@tiptap/extension-character-count'

export default defineComponent({
    components: {
        EditorContent,
    },
    props: {
        placeholder: {
            type: String,
            default: "Введите текст"
        },
        modelValue: {
            type: String,
            default: '',
        },
        limit: {
            type: Number,
            default: 4098
        }
    },
    emits: ['update:modelValue'],
    data: () => ({
        editor: null,
        inputLink: null,
    }),
    mounted() {
        // Инициализация редактора Tiptap
        this.editor = new Editor({
            editorProps: {
                attributes: {
                    class: "message-text"
                }
            },
            extensions: [
                StarterKit,
                Underline,
                Link.configure({
                    openOnClick: false,
                    autolink: false,
                    protocols: ['https', 'http'],
                    linkOnPaste: false,
                }),
                Placeholder.configure({
                    placeholder: this.placeholder,
                }),
                CharacterCount.configure({
                    limit: this.limit,
                })
            ],
            content: this.modelValue,
            onUpdate: () => {
                // Обновление значения модели при изменении содержимого редактора
                this.$emit('update:modelValue', this.editor.getHTML())
            },
        })
    },

    beforeUnmount() {
        // Уничтожение редактора при удалении компонента
        this.editor.destroy()
    },
    methods: {
        // Вставка выбранного эмодзи в текст
        insertEmoji({ i }) {
            this.editor.commands.insertContent(i);
        },
        // Добавление ссылки в текст
        addLink() {
            this.editor.commands.setLink({
                href: this.inputLink
            });
            this.inputLink = null;
        }
    },
    watch: {
        modelValue(value) {
            // Обновление содержимого редактора при изменении значения модели
            const isSame = this.editor.getHTML() === value
            if (isSame) {
                return
            }
            this.editor.commands.setContent(value, false)
        },
    },
})
</script>

<style lang="scss">
/* Основные стили редактора */
.tiptap {
    &-container {
        box-shadow: none !important;
    }

    &-text-limit {
        display: block;
        font-size: 0.7em;
        text-align: right;
        margin-left: auto;
    }
    &-format-buttons {
        display: grid;
        grid-template-columns: repeat(7, 24px);
        align-items: center;
        gap: 6px;

        .button-format {
            width: 24px;
            height: 24px;
            font-size: 12px;
            padding: 0;
            border-radius: 3px;
            &:not(:hover, .active) {
                color: #000;
                background: #fff;
            }
        }

        margin-bottom: 12px;
    }

    >*+* {
        margin-top: 0.75em;
    }

    p {
        margin: 0 !important;
    }

    p.is-editor-empty:first-child::before {
        color: #adb5bd;
        content: attr(data-placeholder);
        float: left;
        height: 0;
        pointer-events: none;
    }
}
</style>
