<template>
  <div>
    <skijasi-breadcrumb-row> </skijasi-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('edit_content')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("content.edit.title") }}</h3>
          </div>
          <vs-row vs-justify="center" vs-align="center">
            <skijasi-text
              v-model="content.label"
              size="6"
              :label="$t('content.add.field.label.title')"
              :placeholder="$t('content.add.field.label.placeholder')"
              :alert="errors.label"
              autofocus
            ></skijasi-text>

            <skijasi-text
              v-model="content.slug"
              size="6"
              :label="$t('content.add.field.slug.title')"
              :placeholder="$t('content.add.field.slug.placeholder')"
              :alert="errors.slug"
            ></skijasi-text>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-prompt
        color="primary"
        @cancel="copyItemName = ''"
        @accept="copyItem"
        @close="
          willCopyItem = {};
          copyItemName = '';
        "
        :is-valid="validName"
        :active.sync="copyItemDialog"
      >
        <div class="con-exemple-prompt">
          <skijasi-text
            v-model="copyItemName"
            size="12"
            :label="$t('content.add.field.content.name.title')"
            :placeholder="$t('content.add.field.content.name.placeholder')"
          ></skijasi-text>
        </div>
      </vs-prompt>
      <vs-col col-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("content.edit.secondTitle") }}</h3>
          </div>
          <table class="skijasi-table">
            <thead>
              <th></th>
              <th>{{ $t("content.add.field.content.label.title") }}</th>
              <th>{{ $t("content.add.field.content.name.title") }}</th>
              <th>{{ $t("content.add.field.content.type") }}</th>
              <th></th>
            </thead>

            <tbody>
              <template v-for="(item, key, index) in items">
                <tr :key="items.name + '-' + key">
                  <td>
                    <vs-icon
                      icon="chevron_right"
                      :class="{
                        'expandable rotate': opened.includes(index),
                        expandable: !opened.includes(index),
                      }"
                      @click="toggle(index)"
                      v-if="contentHelper.isMultipleFields(item)"
                    ></vs-icon>
                  </td>
                  <td>
                    <skijasi-text
                      v-model="item.label"
                      size="12"
                      :label="$t('content.add.field.content.label.title')"
                      :placeholder="
                        $t('content.add.field.content.label.placeholder')
                      "
                    ></skijasi-text>
                  </td>
                  <td>
                    <skijasi-text
                      v-model="item.name"
                      size="12"
                      :label="$t('content.add.field.content.name.title')"
                      :placeholder="
                        $t('content.add.field.content.name.placeholder')
                      "
                      disabled
                    ></skijasi-text>
                  </td>
                  <td>
                    <skijasi-select
                      v-model="item.type"
                      size="12"
                      :label="$t('content.add.field.content.type')"
                      :items="fieldList"
                      :value="item.type"
                      @input="changeDataType(item, $event)"
                    ></skijasi-select>
                  </td>
                  <td>
                    <vs-button
                      color="primary"
                      type="relief"
                      @click="openCopyItemDialog(item)"
                    >
                      <vs-icon icon="content_copy"></vs-icon>
                    </vs-button>
                    <vs-button
                      color="danger"
                      type="relief"
                      @click="dropItem(items, item, key)"
                    >
                      <vs-icon icon="delete"></vs-icon>
                    </vs-button>
                    <vs-button
                      color="warning"
                      type="relief"
                      @click="moveUp(index)"
                      v-if="Object.values(items).length > 1"
                      :disabled="index === 0"
                    >
                      <vs-icon icon="expand_less"></vs-icon>
                    </vs-button>
                    <vs-button
                      color="warning"
                      type="relief"
                      @click="moveDown(index)"
                      v-if="Object.values(items).length > 1"
                      :disabled="index === Object.values(items).length - 1"
                    >
                      <vs-icon icon="expand_more"></vs-icon>
                    </vs-button>
                  </td>
                </tr>
                <tr
                  :key="items.name + '-' + key + '-opened'"
                  v-if="opened.includes(index)"
                >
                  <td colspan="5" class="clear-td">
                    <skijasi-content
                      :items="item"
                      v-model="invalid"
                    ></skijasi-content>
                  </td>
                </tr>
              </template>
            </tbody>
            <skijasi-content-add-field
              v-model="invalid"
              @click="addItem($event)"
            ></skijasi-content-add-field>
          </table>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card>
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon>
                {{ $t("content.edit.button") }}
              </vs-button>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
    <vs-row v-else>
      <vs-col vs-lg="12">
        <vs-card>
          <vs-row>
            <vs-col vs-lg="12">
              <h3>{{ $t("content.warning.notAllowedToEdit") }}</h3>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import * as _ from "lodash";
import contentHelper from "../../utils/content-helper";

export default {
  name: "ContentManagementEdit",
  components: {},
  data: () => ({
    errors: {},
    content: {
      slug: "",
      label: "",
    },
    opened: [],
    animated: false,
    items: {},
    willCopyItem: {},
    copyItemDialog: false,
    copyItemName: "",
    invalid: false,
    contentHelper,
  }),
  computed: {
    validName() {
      return this.copyItemName.length > 0;
    },
    fieldList: {
      get() {
        return contentHelper.getAllTypeContent();
      },
    },
    tableStyles() {
      return {
        "padding-left": "15px",
      };
    },
  },
  mounted() {
    this.getContent();
  },
  methods: {
    getContent() {
      this.$openLoader();
      this.$api.skijasiContent
        .read({
          id: this.$route.params.id,
          filtered: true,
        })
        .then((response) => {
          this.$closeLoader();
          this.selected = [];
          this.content.label = response.data.content.label;
          this.content.slug = response.data.content.slug;
          this.items = response.data.content.value;
        })
        .catch((error) => {
          this.$closeLoader();
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        });
    },
    submitForm() {
      if (!this.invalid) {
        this.$openLoader();
        this.$api.skijasiContent
          .edit({
            id: this.$route.params.id,
            slug: this.content.slug,
            label: this.content.label,
            value: JSON.stringify(this.items),
          })
          .then((response) => {
            this.$closeLoader();
            this.$vs.notify({
              title: this.$t("alert.success"),
              text: response.message,
              color: "success",
            });
            this.$router.push({ name: "ContentManagementBrowse" });
          })
          .catch((error) => {
            this.$closeLoader();
            this.$vs.notify({
              title: this.$t("alert.danger"),
              text: error.message,
              color: "danger",
            });
          });
      } else {
        this.$vs.dialog({
          type: "confirm",
          color: "warning",
          title: this.$t("action.delete.title"),
          text: this.$t("content.warning.fieldNotSaved"),
          accept: () => {
            this.invalid = false;
            this.submitForm();
          },
          acceptText: this.$t("action.yes"),
          cancelText: this.$t("action.no"),
          cancel: () => {},
        });
      }
    },
    addItem(event) {
      this.$set(this.items, Object.keys(event), Object.values(event)[0]);
    },
    toggle(index) {
      if (this.opened.includes(index)) {
        let idx = this.opened.indexOf(index);
        this.opened.splice(idx, 1);
      } else {
        this.opened.push(index);
      }
    },
    dropItem(items, item, key) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: () => this.$delete(items, key),
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    copyItem() {
      let item = _.cloneDeep({
        ...this.willCopyItem,
        label: "",
        name: this.copyItemName,
      });
      this.$set(this.items, this.copyItemName, item);
      this.copyItemName = "";
    },
    openCopyItemDialog(item) {
      this.willCopyItem = item;
      this.copyItemDialog = true;
    },
    changeDataType(item, event) {
      if (event === "group") {
        item.data = {};
      }

      if (event === "text" || event === "image") {
        item.data = "";
      }

      if (event === "url") {
        item.data = {
          url: "",
          text: "",
        };
      }
    },
    moveDown(index) {
      const temp = [];
      var tempObject = {};
      for (const item in this.items) {
        if (Object.hasOwnProperty.call(this.items, item)) {
          temp.push(this.items[item]);
        }
      }
      [temp[index], temp[index + 1]] = [temp[index + 1], temp[index]];

      tempObject = this.convertArrayToObject(temp, "name");
      this.items = tempObject;
    },
    moveUp(index) {
      const temp = [];
      var tempObject = {};
      for (const item in this.items) {
        if (Object.hasOwnProperty.call(this.items, item)) {
          temp.push(this.items[item]);
        }
      }
      [temp[index], temp[index - 1]] = [temp[index - 1], temp[index]];

      tempObject = this.convertArrayToObject(temp, "name");
      this.items = tempObject;
    },
    convertArrayToObject(array, key) {
      const initialValue = {};
      return array.reduce((obj, item) => {
        return {
          ...obj,
          [item[key]]: item,
        };
      }, initialValue);
    },
  },
};
</script>

<style>
.drag_icon:hover {
  cursor: all-scroll;
}
.expandable {
  cursor: pointer;
  user-select: none;
  animation: all 5s;
  display: inline-block;
}
.rotate {
  transform: rotate(90deg);
}
.clear-td {
  padding: 0 !important;
  border-top: none !important;
}
</style>
