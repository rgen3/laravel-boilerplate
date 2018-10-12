<template>
  <div class="mx-4 py-3">
    <editor class="editor" :extensions="extensions">

      <div class="menubar mb-2" slot="menubar" slot-scope="{ nodes, marks }">
        <div v-if="nodes && marks">

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': marks.bold.active() }"
            @click="marks.bold.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'bold']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': marks.italic.active() }"
            @click="marks.italic.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'italic']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': marks.strike.active() }"
            @click="marks.strike.command"
          >
            strike
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': marks.underline.active() }"
            @click="marks.underline.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'underline']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            @click="marks.code.command"
            :class="{ 'is-active': marks.code.active() }"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'code']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.paragraph.active() }"
            @click="nodes.paragraph.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'paragraph']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.heading.active({ level: 1 }) }"
            @click="nodes.heading.command({ level: 1 })"
          >
            H1
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.heading.active({ level: 2 }) }"
            @click="nodes.heading.command({ level: 2 })"
          >
            H2
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.heading.active({ level: 3 }) }"
            @click="nodes.heading.command({ level: 3 })"
          >
            H3
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.bullet_list.active() }"
            @click="nodes.bullet_list.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'list-ul']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.ordered_list.active() }"
            @click="nodes.ordered_list.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'list-ol']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.blockquote.active() }"
            @click="nodes.blockquote.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'quote-right']"
            ></font-awesome-icon>
          </button>

          <button
            class="btn btn-sm btn-outline-info"
            :class="{ 'is-active': nodes.code_block.active() }"
            @click="nodes.code_block.command"
          >
            <font-awesome-icon
              class="text-info mx-2"
              :icon="['fa', 'code']"
            ></font-awesome-icon>
          </button>

        </div>
      </div>

      <div class="px-3 py-2 bg-white" slot="content" slot-scope="props">
        <h2>
          Hi there,
        </h2>
        <p>
          this is a very <em>basic</em> example of tiptap.
        </p>
        <pre><code>body { display: none; }</code></pre>
        <ul>
          <li>
            A regular list
          </li>
          <li>
            With regular items
          </li>
        </ul>
        <blockquote>
          It's amazing 👏
          <br>
          – mom
        </blockquote>
      </div>

    </editor>
  </div>
</template>
<script>
import { Editor } from 'tiptap'
import {
  BlockquoteNode,
  BulletListNode,
  CodeBlockNode,
  HardBreakNode,
  HeadingNode,
  ListItemNode,
  OrderedListNode,
  TodoItemNode,
  TodoListNode,
  BoldMark,
  CodeMark,
  ItalicMark,
  LinkMark,
  StrikeMark,
  UnderlineMark,
  HistoryExtension
} from 'tiptap-extensions'

export default {
  components: { Editor },
  data() {
    return {
      extensions: [
        new BlockquoteNode(),
        new BulletListNode(),
        new CodeBlockNode(),
        new HardBreakNode(),
        new HeadingNode({ maxLevel: 3 }),
        new ListItemNode(),
        new OrderedListNode(),
        new TodoItemNode(),
        new TodoListNode(),
        new BoldMark(),
        new CodeMark(),
        new ItalicMark(),
        new LinkMark(),
        new StrikeMark(),
        new UnderlineMark(),
        new HistoryExtension()
      ]
    }
  }
}
</script>
