import { mount } from "@vue/test-utils";
import UserList from "@/components/UserList.vue";
import flushPromises from "flush-promises";
import { describe, it, expect, vi, beforeEach } from "vitest";

// Mock fetch with fake user data
beforeEach(() => {
  global.fetch = vi.fn(() =>
    Promise.resolve({
      ok: true,
      json: () =>
        Promise.resolve([
          { id: 1, name: "Alice" },
          { id: 2, name: "Bob" },
        ]),
    })
  );
});

describe("UserList.vue", () => {
  it("opens the modal when a UserCard is clicked", async () => {
    const wrapper = mount(UserList, {
      global: {
        stubs: {
          // Stub UserModal and UserCard to simulate behavior
          UserModal: {
            template: '<div class="user-modal">UserModal</div>',
            props: ["user"],
          },
          UserCard: {
            props: ["user"],
            template: `<div class="user-card" @click="$emit('click')">{{ user.name }}</div>`,
          },
        },
      },
    });

    await flushPromises(); // Wait for fetch and reactivity to settle

    const userCards = wrapper.findAll(".user-card");
    expect(userCards.length).toBeGreaterThan(0);

    await userCards[0].trigger("click");

    // Check modal is rendered
    const modal = wrapper.find(".user-modal");
    expect(modal.exists()).toBe(true);
  });
});
