import { mount } from "@vue/test-utils";
import { describe, it, expect, vi } from "vitest";
import UserList from "@/components/UserList.vue";

vi.stubGlobal(
  "fetch",
  vi.fn(() =>
    Promise.resolve({
      json: () =>
        Promise.resolve([
          {
            id: 1,
            name: "John Doe",
            weather: { description: "Sunny", temp: "75°F" },
          },
        ]),
    })
  )
);

describe("UserList.vue", () => {
  it("opens the modal when a UserCard is clicked", async () => {
    const wrapper = mount(UserList);

    // Wait for fetchData + DOM to update
    await new Promise((resolve) => setTimeout(resolve, 0));
    await wrapper.vm.$nextTick();

    // Click the user card
    await wrapper.findComponent({ name: "UserCard" }).trigger("click");

    // Modal should now be visible
    expect(wrapper.findComponent({ name: "UserModal" }).exists()).toBe(true);
  });
});
